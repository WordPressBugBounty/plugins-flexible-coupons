<?php

/**
 * Implementation of the library.
 *
 * @package WPDesk\Library\WPCoupons
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\EditorIntegration;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\Shortcode;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon\GenerateCoupon;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\NullProductFields;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Shortcodes;
use FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FlexibleCouponsVendor\WPDesk\View\Resolver\ChainResolver;
use FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings;
/**
 * Main class for the implementation of the coupon library.
 *
 * @package WPDesk\Library\WPCoupons
 */
class CouponsIntegration implements \FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable, \FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableCollection
{
    use HookableParent;
    /**
     * @var EditorIntegration
     */
    protected $editor;
    /**
     * @var Renderer
     */
    protected $renderer;
    /**
     * @var ProductFields
     */
    protected $product_fields;
    /**
     * @var array
     */
    protected $forms;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var bool
     */
    private static $is_pro = \false;
    /**
     * @var GenerateCoupon
     */
    public function __construct(\FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\EditorIntegration $editor)
    {
        $this->editor = $editor;
        $this->set_product_fields(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\NullProductFields());
    }
    public static function set_pro()
    {
        self::$is_pro = \true;
    }
    /**
     * @return bool
     */
    public static function is_pro() : bool
    {
        return self::$is_pro;
    }
    /**
     * @return LoggerInterface
     */
    protected function get_logger() : \Psr\Log\LoggerInterface
    {
        return new \Psr\Log\NullLogger();
    }
    /**
     * @return Renderer
     */
    protected function get_renderer() : \FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer
    {
        $resolver = new \FlexibleCouponsVendor\WPDesk\View\Resolver\ChainResolver();
        $resolver->appendResolver(new \FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver(\trailingslashit(__DIR__) . 'Views/dashboard'));
        $resolver->appendResolver(new \FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver(\trailingslashit(__DIR__) . 'Views/editor'));
        return new \FlexibleCouponsVendor\WPDesk\View\Renderer\SimplePhpRenderer($resolver);
    }
    /**
     * @param ProductFields $product_fields
     */
    public function set_product_fields(\FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields $product_fields)
    {
        $this->product_fields = $product_fields;
    }
    /**
     * @return ProductFields
     */
    protected function get_product_fields() : \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields
    {
        return $this->product_fields;
    }
    /**
     * @return Shortcode[]
     */
    protected function shortcodes_definition() : array
    {
        return [new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Shortcodes\CouponCode(), new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Shortcodes\CouponValue()];
    }
    protected function get_persistence() : \FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer
    {
        return new \FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer('flexible_coupons_');
    }
    private function get_shortcodes_definition() : array
    {
        return \apply_filters('fc/core/shortcodes/definition', $this->shortcodes_definition());
    }
    /**
     *
     * @return void
     */
    public function hooks()
    {
        $post_meta = new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta();
        $logger = $this->get_logger();
        $persistence = $this->get_persistence();
        $renderer = $this->get_renderer();
        $product_fields = $this->get_product_fields();
        $shortcodes = $this->get_shortcodes_definition();
        $pdf = new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\PDF($this->editor, $this->get_renderer(), $product_fields, $post_meta, $shortcodes);
        $download = new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\Download($pdf, $post_meta);
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\Assets($this->editor->get_post_type(), $shortcodes));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Cart\Cart($product_fields, $post_meta, $persistence, $logger));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\MyAccount($renderer, $post_meta));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Order\MakeOrder($post_meta));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Order\OrderMetaBox($renderer, $post_meta));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Coupon\GenerateCoupon($renderer, $product_fields, $persistence, $post_meta, $logger));
        $this->add_hookable($download);
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm($persistence, $renderer));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\ProductEditPage($persistence, $renderer, $product_fields, $post_meta, $this->editor->get_post_type()));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\ProductVariationEditPage($persistence, $renderer, $product_fields, $post_meta, $this->editor->get_post_type()));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\SaveProductSimpleData($product_fields, $post_meta));
        $this->add_hookable(new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Product\SaveProductVariationData($product_fields, $post_meta));
        \do_action('fc/core/init', new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PluginAccess($renderer, $logger, $persistence, $pdf, $download, $shortcodes, $post_meta, $product_fields));
    }
}
