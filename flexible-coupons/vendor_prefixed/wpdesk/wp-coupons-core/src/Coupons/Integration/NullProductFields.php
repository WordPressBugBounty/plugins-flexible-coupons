<?php

/**
 * Integration. Coupon Fields.
 *
 * @package WPDesk\Library\WPCoupons
 */
namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields;
/**
 * Define default fields for coupon product.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class NullProductFields implements \FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields
{
    /**
     * @return array
     */
    public function get() : array
    {
        return [];
    }
    public function is_premium() : bool
    {
        return \false;
    }
}