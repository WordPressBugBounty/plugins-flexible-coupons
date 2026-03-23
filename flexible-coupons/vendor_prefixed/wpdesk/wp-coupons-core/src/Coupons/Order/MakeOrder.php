<?php

/**
 * Integration. Order.
 *
 * @package WPDesk\Library\WPCoupons
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Order;

use FlexibleCouponsVendor\FlexibleCouponsProVendor\WPDesk\Library\CouponInterfaces\ShortcodeData;
use WC_Order_Item_Coupon;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\Helper;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\WpmlHelper;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WC_Coupon;
use WC_Order;
/**
 * Fire action after make order.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class MakeOrder implements Hookable
{
    private const AMOUNT_ADJUSTED = '_fcpdf_multiuse_amount_adjusted';
    /**
     * @var PostMeta
     */
    private $postmeta;
    /**
     * @param PostMeta $postmeta
     */
    public function __construct(PostMeta $postmeta)
    {
        $this->postmeta = $postmeta;
    }
    /**
     * Fires hooks.
     */
    public function hooks()
    {
        add_action('woocommerce_order_status_changed', [$this, 'order_processed'], 20, 4);
        add_action('woocommerce_order_item_meta_end', [$this, 'display_coupons_links'], 8, 3);
    }
    public function display_coupons_links($item_id, $item, $order)
    {
        $coupon_key = 'fcpdf_order_item_' . $item_id . '_coupon_id';
        $coupon_id = (int) $order->get_meta($coupon_key, \true);
        if (!$coupon_id) {
            $coupon_id = (int) $order->get_meta('_' . $coupon_key, \true);
        }
        $coupon_data = get_post_meta($coupon_id, '_fcpdf_coupon_data', \true);
        if (!empty($coupon_data) && $item) {
            $coupon = new WC_Coupon($coupon_id);
            $coupon_code = $coupon->get_id() ? $coupon->get_code() : '';
            $download_url = $coupon->get_id() ? Helper::make_coupon_url($coupon_data) : '';
            if ($download_url && $coupon_code) {
                echo '<p><a href="' . \esc_url($download_url) . '"><strong>' . esc_html__('Download PDF coupon', 'flexible-coupons') . '</strong></a></p>';
            }
        }
    }
    /**
     * @param int           $order_id
     * @param string        $old_status
     * @param string        $new_status
     * @param WC_Order|null $order
     */
    public function order_processed(int $order_id, string $old_status = '', string $new_status = '', $order = null): void
    {
        if (!in_array($new_status, ['processing', 'completed'], \true)) {
            return;
        }
        if (!$order instanceof WC_Order) {
            $order = wc_get_order($order_id);
        }
        if (!$order instanceof WC_Order) {
            return;
        }
        if ($order->get_meta(self::AMOUNT_ADJUSTED, \true)) {
            return;
        }
        $coupon_items = $order->get_items('coupon');
        $did_update = \false;
        foreach ($coupon_items as $coupon_item) {
            if (!$coupon_item instanceof WC_Order_Item_Coupon) {
                continue;
            }
            $total = (float) $coupon_item->get_discount() + (float) $coupon_item->get_discount_tax();
            $order_currency = $order->get_currency();
            $total = WpmlHelper::get_default_amount_by_current_exchange($total, $order_currency);
            $coupon_code = $coupon_item->get_code();
            $coupon_id = (int) wc_get_coupon_id_by_code($coupon_code);
            $coupon_data = $this->postmeta->get_private($coupon_id, 'fcpdf_coupon_data');
            if (empty($coupon_data)) {
                continue;
            }
            $coupon_object = new WC_Coupon($coupon_id);
            $usage_limit = $coupon_object->get_usage_limit();
            if (!$usage_limit) {
                $amount = (float) $coupon_object->get_amount();
                $amount = WpmlHelper::get_default_amount_by_current_exchange($amount, $order_currency);
                $new_amount = max(0, $amount - $total);
                $coupon_object->set_amount($new_amount);
                $coupon_object->save();
                $did_update = \true;
            }
        }
        if ($did_update) {
            $order->update_meta_data(self::AMOUNT_ADJUSTED, '1');
            $order->save();
        }
    }
}
