<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers;

/**
 * All plugin related links
 */
class Links
{
    /**
     * @return string
     */
    public static function get_doc_link(): string
    {
        $docs_link = 'https://flexiblecoupons.net/sk/wp-coupons-docs-en';
        if (get_locale() === 'pl_PL') {
            $docs_link = 'https://www.wpdesk.pl/sk/wp-coupons-docs-pl';
        }
        return $docs_link;
    }
    /**
     * @return string
     */
    public static function get_pro_link(): string
    {
        $pro_link = 'https://flexiblecoupons.net/sk/wp-coupons-pro-en';
        if (get_locale() === 'pl_PL') {
            $pro_link = 'https://www.wpdesk.pl/sk/wp-coupons-pro-pl';
        }
        return $pro_link;
    }
    /**
     * @return string
     */
    public static function get_fcs_link(): string
    {
        $sending_link = 'https://flexiblecoupons.net/sk/wp-coupons-pro-as-en';
        if (get_locale() === 'pl_PL') {
            $sending_link = 'https://www.wpdesk.pl/sk/wp-coupons-pro-as-pl';
        }
        return $sending_link;
    }
    public static function get_fcmpdf_link(): string
    {
        $sending_link = 'https://flexiblecoupons.net/sk/wp-coupons-pro-pdf-en/';
        if (get_locale() === 'pl_PL') {
            $sending_link = 'https://www.wpdesk.pl/sk/wp-coupons-pro-pdf-pl';
        }
        return $sending_link;
    }
    /**
     * @return string
     */
    public static function get_bundle_link(): string
    {
        $bundle_link = 'https://flexiblecoupons.net/sk/wp-coupons-pro-bundle-en';
        if (get_locale() === 'pl_PL') {
            $bundle_link = 'https://www.wpdesk.pl/sk/wp-coupons-pro-bundle-pl';
        }
        return $bundle_link;
    }
    /**
     * @return string
     */
    public static function get_fcs_doc_delay_type_link(): string
    {
        $docs_link = 'https://flexiblecoupons.net/sk/as-advanced-sending-docs-product-settings';
        if (get_locale() === 'pl_PL') {
            $docs_link = 'https://wpdesk.pl/sk/as-advanced-sending-docs-product-settings-pl';
        }
        return $docs_link;
    }
    /**
     * @return string
     */
    public static function get_fcs_doc_link(): string
    {
        $docs_link = 'https://flexiblecoupons.net/sk/as-advanced-sending-docs';
        if (get_locale() === 'pl_PL') {
            $docs_link = 'https://wpdesk.pl/sk/as-advanced-sending-docs-pl';
        }
        return $docs_link;
    }
    public static function get_fcci_buy_link(): string
    {
        $sending_link = 'https://flexiblecoupons.net/sk/wp-coupons-pro-import-en';
        if (get_locale() === 'pl_PL') {
            $sending_link = 'https://www.wpdesk.pl/sk/wp-coupons-pro-import-pl';
        }
        return $sending_link;
    }
}
