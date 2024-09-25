<?php

/**
 * Integration. Coupon management.
 *
 * @package WPDesk\Library\WPCoupons
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon;

use Exception;
use WC_Coupon;
use WC_Order_Item;
use Psr\Log\LoggerInterface;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\ProductEditPage;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Exception\EmailException;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Email\FlexibleCouponsBaseEmail;
use FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer;
/**
 * Class responsible for creating, removing and downloading coupons.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class GenerateCoupon implements \FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable
{
    const WOOCOMMERCE_COUPON_SLUG = 'shop_coupon';
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var array
     */
    private $product_fields;
    /**
     * @var WordpressOptionsContainer
     */
    private $settings;
    /**
     * @var PostMeta
     */
    private $postmeta;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @param Renderer                  $renderer       Renderer.
     * @param ProductFields             $product_fields Product fields.
     * @param WordpressOptionsContainer $settings       Settings.
     * @param PostMeta                  $postmeta       PostMeta.
     */
    public function __construct(\FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer $renderer, \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields $product_fields, \FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer $settings, \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta $postmeta, \Psr\Log\LoggerInterface $logger)
    {
        $this->renderer = $renderer;
        $this->product_fields = $product_fields;
        $this->settings = $settings;
        $this->postmeta = $postmeta;
        $this->logger = $logger;
    }
    /**
     * Fires hooks.
     */
    public function hooks()
    {
        \add_action('wp_ajax_generate_coupon', [$this, 'wp_ajax_generate_coupon'], 2, 10);
        \add_action('before_delete_post', [$this, 'delete_order_item_postmeta'], 2, 10);
        $this->register_order_status_hooks();
    }
    /**
     * @return void
     */
    private function register_order_status_hooks()
    {
        $auto_send_status = \str_replace('wc-', '', $this->settings->get_fallback('automatic_sending', ''));
        $order_status_action = 'woocommerce_order_status_' . $auto_send_status;
        if ('0' !== $auto_send_status) {
            \add_action($order_status_action, [$this, 'create_coupon_for_order_status'], 10, 2);
        }
    }
    /**
     * @param int $order_id Order ID.
     *
     * @throws Exception Throw exception for items.
     */
    public function create_coupon_for_order_status(int $order_id)
    {
        try {
            $this->generate_coupons_for_order_items($order_id);
        } catch (\Exception $e) {
            $this->logger->warning(\sprintf('Failed to generate coupon for order %d. Original error: %s', $order_id, $e->getMessage()));
        }
    }
    /**
     * Maybe send email with coupon.
     *
     * @param int   $order_id Order ID.
     * @param array $meta     Meta.
     */
    private function should_send_email(int $order_id, array $meta) : void
    {
        $wc_registered_emails = \WC()->mailer()->get_emails();
        foreach ($wc_registered_emails as $email) {
            if (!$email instanceof \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Email\FlexibleCouponsBaseEmail) {
                continue;
            }
            try {
                /**
                 * Filter whether we should send email or not.
                 *
                 * @param bool true                Send by default.
                 * @param FlexibleCouponsBaseEmail $email
                 * @param int $order_id            WC_Order id
                 * @param array  $meta             Coupon meta data.
                 *
                 * @since 1.5.9
                 */
                $should_send = \apply_filters('fc/core/email/should_send_email', \true, $email, $order_id, $meta);
                if ($should_send) {
                    $email->send_mail($order_id, $meta);
                }
            } catch (\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Exception\EmailException $e) {
                $this->logger->warning(\sprintf('Failed to send email. Reason: %s, Meta: $s', $e->getMessage(), \json_encode(['meta' => $meta])));
            }
        }
    }
    /**
     * @param int $order_id Order ID.
     *
     * @return void
     * @throws Exception
     */
    private function generate_coupons_for_order_items(int $order_id)
    {
        $order = \wc_get_order($order_id);
        $items = $order->get_items();
        foreach ($items as $item) {
            $this->create_item_coupon($item);
        }
    }
    /**
     * @param WC_Order_Item $item
     *
     * @return array
     * @throws Exception
     */
    private function create_item_coupon(\WC_Order_Item $item) : array
    {
        $meta = [];
        $is_coupon_item = 'yes' === $this->postmeta->get_private($item->get_product_id(), \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\ProductEditPage::PRODUCT_COUPON_SLUG);
        $is_disabled = \false;
        if ($item->get_variation_id()) {
            $is_disabled = 'yes' === $this->postmeta->get_private($item->get_variation_id(), 'flexible_coupon_disable_pdf', 'no');
        }
        if ($is_coupon_item && !$is_disabled) {
            foreach ($this->product_fields->get() as $id => $field) {
                $value = \wc_get_order_item_meta($item->get_id(), $id, \true);
                if ($value) {
                    $meta[$id] = $value;
                }
            }
            return $this->create_coupon($item->get_order_id(), $item, $meta);
        }
        return [];
    }
    /**
     * Create coupon.
     *
     * Return [ 'hash', 'order_id', 'coupon_id', 'coupon_code', product_id, item_id, coupon_url' ].
     *
     * @param int           $order_id              Order ID.
     * @param WC_Order_Item $item                  Item.
     * @param array         $product_fields_values Product fields values.
     *
     * @return array
     * @throws Exception
     */
    private function create_coupon(int $order_id, \WC_Order_Item $item, array $product_fields_values) : array
    {
        $order = \wc_get_order($order_id);
        $has_coupon = (int) $order->get_meta('fcpdf_order_item_' . $item->get_id() . '_coupon_id');
        if (!$has_coupon) {
            $has_coupon = (int) $order->get_meta('_fcpdf_order_item_' . $item->get_id() . '_coupon_id');
        }
        if (!$has_coupon) {
            $coupon_code = (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon\CouponCode($this->settings, $item))->get();
            $coupon_id = (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon\Coupon($this->postmeta, $this->settings))->insert($item, $coupon_code, $product_fields_values, $order_id);
            if ($coupon_id) {
                $coupon_meta = (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon\CouponMeta($this->postmeta))->update($item, $order_id, $coupon_id, $coupon_code);
                $this->should_send_email($order_id, \array_merge($product_fields_values, $coupon_meta));
                return $coupon_meta;
            }
        }
        return [];
    }
    /**
     * Delete coupon item relation from order.
     *
     * @param int $coupon_id
     */
    public function delete_order_item_postmeta(int $coupon_id)
    {
        global $post_type;
        if (self::WOOCOMMERCE_COUPON_SLUG !== $post_type) {
            return;
        }
        $meta = $this->postmeta->get_private($coupon_id, 'fcpdf_coupon_data', \true);
        if (!isset($meta['item_id']) || !isset($meta['order_id'])) {
            return;
        }
        $order = \wc_get_order($meta['order_id']);
        if (!$order instanceof \WC_Order) {
            return;
        }
        $order->delete_meta_data('fcpdf_order_item_' . $meta['item_id'] . '_coupon_id');
        $order->delete_meta_data('fcpdf_order_item_' . $meta['item_id'] . '_coupon_code');
        $order->delete_meta_data('_fcpdf_order_item_' . $meta['item_id'] . '_coupon_id');
        $order->delete_meta_data('_fcpdf_order_item_' . $meta['item_id'] . '_coupon_code');
        $order->save();
    }
    /**
     * Get success HTML response.
     *
     * @param array $coupon_data Coupon data.
     *
     * @return string
     */
    private function get_success_html(array $coupon_data) : string
    {
        $item_id = $coupon_data['item_id'];
        $order_id = $coupon_data['order_id'];
        $meta_coupon_id = 'fcpdf_order_item_' . $coupon_data['item_id'] . '_coupon_id';
        $order = \wc_get_order($order_id);
        $item = $order->get_item($item_id);
        $coupon_id = (int) $order->get_meta($meta_coupon_id);
        if (!$coupon_id) {
            $coupon_id = (int) $order->get_meta('_' . $meta_coupon_id);
        }
        $coupon = new \WC_Coupon($coupon_id);
        $coupon_code = $coupon->get_code() ?: '';
        $coupon_url = $coupon_id ? \admin_url('post.php?post=' . $coupon_id . '&action=edit') : '';
        $product_url = $coupon_id ? \admin_url('post.php?post=' . $item->get_product_id() . '&action=edit') : '';
        $download_url = $coupon_data['coupon_url'];
        $data = ['order_id' => $order_id, 'product_id' => $item->get_product_id(), 'variation_id' => $item->get_variation_id(), 'product_name' => $item->get_name(), 'product_url' => $product_url, 'coupon_id' => $coupon_id, 'coupon_url' => $coupon_url, 'coupon_code' => $coupon_code, 'coupon_title' => $coupon_code, 'download_url' => $download_url];
        // phpcs:disable
        return $this->renderer->render('html-order-coupon-generated', $data);
    }
    public function wp_ajax_generate_coupon()
    {
        if (!isset($_POST['security']) || !\wp_verify_nonce($_POST['security'], 'generate_coupon')) {
            \wp_send_json_error('Nonce error');
        } else {
            $order_id = isset($_POST['order_id']) ? (int) $_POST['order_id'] : \false;
            // WPCS: CSRF ok, input var ok.
            $item_id = isset($_POST['item_id']) ? (int) $_POST['item_id'] : \false;
            // WPCS: CSRF ok, input var ok.
            if (!$order_id || !$item_id) {
                \wp_send_json_error(\esc_html__('Cannot generate coupon. Unknown order ID or item ID', 'flexible-coupons'));
            }
            $order = \wc_get_order($order_id);
            $item = $order->get_item($item_id);
            try {
                $coupon = $this->create_item_coupon($item);
                if (!empty($coupon)) {
                    \wp_send_json_success(['html' => $this->get_success_html($coupon)]);
                } else {
                    \wp_send_json_error(\esc_html__('Cannot generate coupon', 'flexible-coupons'));
                }
            } catch (\Exception $e) {
                \wp_send_json_error($e->getMessage());
            }
        }
    }
}
