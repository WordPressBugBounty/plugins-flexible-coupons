<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Validator;

use FlexibleCouponsVendor\WPDesk\Forms\Validator;
class RequiredValidator implements Validator
{
    public function is_valid($value)
    {
        return $value !== null;
    }
    public function get_messages()
    {
        return [];
    }
}
