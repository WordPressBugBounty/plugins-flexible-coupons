<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Shortcodes;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ShortcodeData;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\Shortcode;
/**
 * Coupon price shortcode declaration.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class CouponValue implements \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\Shortcode
{
    const ID = 'coupon_value';
    /**
     * @return string
     */
    public function get_id() : string
    {
        return self::ID;
    }
    /**
     * @return array
     */
    public function definition() : array
    {
        return ['text' => '[coupon_value]', 'top' => 20, 'left' => 20, 'width' => 200, 'height' => 30];
    }
    /**
     * @param ShortcodeData $shortcode_data
     *
     * @return string
     */
    public function get_value(\FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ShortcodeData $shortcode_data) : string
    {
        $order = $shortcode_data->get_order();
        return \wc_price($shortcode_data->get_coupon()->get_amount(), ['currency' => $order->get_currency()]);
    }
}