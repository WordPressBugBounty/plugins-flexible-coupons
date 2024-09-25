<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons;

use Psr\Log\LoggerInterface;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\Download;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\PDF;
use FlexibleCouponsVendor\WPDesk\Persistence\PersistentContainer;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields;
class PluginAccess
{
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var PDF
     */
    private $pdf;
    /**
     * @var Download
     */
    private $download;
    /**
     * @var array
     */
    private $shortcodes;
    /**
     * @var PersistentContainer
     */
    private $persistence;
    /**
     * @var PostMeta
     */
    private $post_meta;
    /**
     * @var ProductFields
     */
    private $product_fields;
    public function __construct(\FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer $renderer, \Psr\Log\LoggerInterface $logger, \FlexibleCouponsVendor\WPDesk\Persistence\PersistentContainer $persistence, \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\PDF $pdf, \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\Download $download, array $shortcodes, \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta $postmeta, \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields $product_fields)
    {
        $this->renderer = $renderer;
        $this->logger = $logger;
        $this->persistence = $persistence;
        $this->pdf = $pdf;
        $this->download = $download;
        $this->shortcodes = $shortcodes;
        $this->post_meta = $postmeta;
        $this->product_fields = $product_fields;
    }
    /**
     * @return Renderer
     */
    public function get_renderer() : \FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer
    {
        return $this->renderer;
    }
    /**
     * @return LoggerInterface
     */
    public function get_logger() : \Psr\Log\LoggerInterface
    {
        return $this->logger;
    }
    /**
     * @return PersistentContainer
     */
    public function get_persistence() : \FlexibleCouponsVendor\WPDesk\Persistence\PersistentContainer
    {
        return $this->persistence;
    }
    /**
     * @return PDF
     */
    public function get_pdf() : \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\PDF
    {
        return $this->pdf;
    }
    /**
     * @return Download
     */
    public function get_download() : \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\PDF\Download
    {
        return $this->download;
    }
    /**
     * @return array
     */
    public function get_shortcodes() : array
    {
        return $this->shortcodes;
    }
    /**
     * @return PostMeta
     */
    public function get_post_meta() : \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta
    {
        return $this->post_meta;
    }
    /**
     * @return ProductFields
     */
    public function get_product_fields() : \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields
    {
        return $this->product_fields;
    }
}
