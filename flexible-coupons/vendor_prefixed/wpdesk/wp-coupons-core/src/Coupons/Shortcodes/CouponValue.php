<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Shortcodes;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ShortcodeData;
use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\Shortcode;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\WpmlHelper;
/**
 * Coupon price shortcode declaration.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class CouponValue implements Shortcode
{
    const ID = 'coupon_value';
    /**
     * @return string
     */
    public function get_id(): string
    {
        return self::ID;
    }
    /**
     * @return array
     */
    public function definition(): array
    {
        return ['text' => '[coupon_value]', 'top' => 20, 'left' => 20, 'width' => 200, 'height' => 30];
    }
    /**
     * @param ShortcodeData $shortcode_data
     *
     * @return string
     */
    public function get_value(ShortcodeData $shortcode_data): string
    {
        $order = $shortcode_data->get_order();
        $amount = (float) $shortcode_data->get_coupon()->get_amount();
        $coupon = $shortcode_data->get_coupon();
        $amount = WpmlHelper::get_amount_by_coupon_exchange_rate($amount, $coupon, WpmlHelper::OTHER_CURRENCY);
        return wc_price($amount, ['currency' => $order->get_currency()]);
    }
}
