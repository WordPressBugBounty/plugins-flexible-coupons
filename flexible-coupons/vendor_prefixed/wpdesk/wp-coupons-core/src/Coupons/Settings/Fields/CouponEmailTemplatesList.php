<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields;

use FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField;
class CouponEmailTemplatesList extends BasicField
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_template_name(): string
    {
        return 'coupon-email-templates-list';
    }
    /**
     * @return true
     */
    public function should_override_form_template(): bool
    {
        return \true;
    }
}
