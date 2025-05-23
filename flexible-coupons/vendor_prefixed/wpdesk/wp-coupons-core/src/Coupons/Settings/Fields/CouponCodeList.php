<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields;

use FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField;
class CouponCodeList extends BasicField
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_template_name(): string
    {
        return 'coupon-code-list';
    }
}
