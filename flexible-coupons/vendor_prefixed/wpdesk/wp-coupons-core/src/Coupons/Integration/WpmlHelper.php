<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration;

class WpmlHelper
{
    public const DEFAULT_CURRENCY = 'default';
    public const OTHER_CURRENCY = 'other';
    public static function get_amount_by_coupon_exchange_rate(float $amount, \WC_Coupon $coupon, string $currency = self::DEFAULT_CURRENCY): float
    {
        $coupon_data = $coupon->get_meta('_fcpdf_coupon_data');
        if (!isset($coupon_data['exchange_rate']) || !self::is_active()) {
            return $amount;
        }
        if ($currency === self::DEFAULT_CURRENCY) {
            return $amount / $coupon_data['exchange_rate'];
        }
        return $amount * $coupon_data['exchange_rate'];
    }
    public static function get_default_amount_by_current_exchange(float $amount, string $currency): float
    {
        if (!self::is_active()) {
            return $amount;
        }
        $exchange_rate = self::get_exchange_rate($currency);
        if ($exchange_rate <= 0) {
            return $amount;
        }
        return $amount / $exchange_rate;
    }
    public static function get_exchange_rate(string $currency): float
    {
        return apply_filters('wcml_raw_price_amount', 100, $currency) / 100;
    }
    public static function is_active(): bool
    {
        $wpml_support = get_option('flexible_coupons_wpml_support', 'no');
        $wcml_active = defined('WCML_VERSION') || isset($GLOBALS['woocommerce_wpml']);
        if ($wpml_support === 'no' || !$wcml_active) {
            return \false;
        }
        $wcml_settings = get_option('_wcml_settings', []);
        return !empty($wcml_settings['enable_multi_currency']);
    }
}
