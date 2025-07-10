<?php

/**
 * Implementation of the library.
 *
 * @package WPDesk\Library\WPCoupons
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons;

use FlexibleCouponsVendor\Psr\Log\LoggerInterface;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\EditorIntegration;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\Shortcode;
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
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Defaults;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Email\EmailPreview;
/**
 * Main class for the implementation of the coupon library.
 *
 * @package WPDesk\Library\WPCoupons
 */
class CouponsIntegration implements Hookable, HookableCollection
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
     * @var string
     */
    private string $plugin_version;
    public function __construct(EditorIntegration $editor, string $plugin_version, LoggerInterface $logger)
    {
        $this->editor = $editor;
        $this->plugin_version = $plugin_version;
        $this->logger = $logger;
        $this->set_product_fields(new NullProductFields());
    }
    public static function set_pro()
    {
        self::$is_pro = \true;
    }
    /**
     * @return bool
     */
    public static function is_pro(): bool
    {
        return self::$is_pro;
    }
    /**
     * @return LoggerInterface
     */
    protected function get_logger(): LoggerInterface
    {
        return $this->logger;
    }
    /**
     * @return Renderer
     */
    protected function get_renderer(): Renderer
    {
        $resolver = new ChainResolver();
        $resolver->appendResolver(new DirResolver(trailingslashit(__DIR__) . 'Views/dashboard'));
        $resolver->appendResolver(new DirResolver(trailingslashit(__DIR__) . 'Views/editor'));
        return new SimplePhpRenderer($resolver);
    }
    /**
     * @param ProductFields $product_fields
     */
    public function set_product_fields(ProductFields $product_fields)
    {
        $this->product_fields = $product_fields;
    }
    /**
     * @return ProductFields
     */
    protected function get_product_fields(): ProductFields
    {
        return $this->product_fields;
    }
    /**
     * @return Shortcode[]
     */
    protected function shortcodes_definition(): array
    {
        return [new Shortcodes\CouponCode(), new Shortcodes\CouponValue()];
    }
    protected function get_persistence(): WordpressOptionsContainer
    {
        return new WordpressOptionsContainer('flexible_coupons_');
    }
    private function get_shortcodes_definition(): array
    {
        return apply_filters('fc/core/shortcodes/definition', $this->shortcodes_definition());
    }
    public static function get_assets_url(): string
    {
        return plugins_url('/assets', dirname(__DIR__));
    }
    /**
     * @return void
     */
    public function hooks()
    {
        $post_meta = new PostMeta();
        $logger = $this->get_logger();
        $persistence = $this->get_persistence();
        $renderer = $this->get_renderer();
        $product_fields = $this->get_product_fields();
        $shortcodes = $this->get_shortcodes_definition();
        $pdf = new PDF\PDF($this->editor, $this->get_renderer(), $product_fields, $post_meta, $shortcodes);
        $download = new PDF\Download($pdf, $post_meta);
        $this->add_hookable(new Integration\Assets($this->editor->get_post_type(), $shortcodes));
        $this->add_hookable(new Cart\Cart($product_fields, $post_meta, $persistence, $logger));
        $this->add_hookable(new Integration\MyAccount($renderer, $post_meta));
        $this->add_hookable(new Order\MakeOrder($post_meta));
        $this->add_hookable(new Order\OrderMetaBox($renderer, $post_meta));
        $this->add_hookable(new Coupon\GenerateCoupon($renderer, $product_fields, $persistence, $post_meta, $logger));
        $this->add_hookable($download);
        $this->add_hookable(new Settings\SettingsForm($persistence, $renderer, $this->plugin_version));
        $this->add_hookable(new Product\ProductEditPage($persistence, $renderer, $product_fields, $post_meta, $this->editor->get_post_type()));
        $this->add_hookable(new Product\ProductVariationEditPage($persistence, $renderer, $product_fields, $post_meta, $this->editor->get_post_type()));
        $this->add_hookable(new Product\SaveProductSimpleData($product_fields, $post_meta));
        $this->add_hookable(new Product\SaveProductVariationData($product_fields, $post_meta));
        $this->add_hookable(new Defaults\DefaultEmailTemplateAjax());
        $this->add_hookable(new EmailPreview());
        do_action('fc/core/init', new PluginAccess($renderer, $logger, $persistence, $pdf, $download, $shortcodes, $post_meta, $product_fields, $this->plugin_version));
    }
}
