<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Validator;

use FlexibleCouponsVendor\WPDesk\Forms\Validator;
class NoValidateValidator implements Validator
{
    public function is_valid($value): bool
    {
        return \true;
    }
    public function get_messages(): array
    {
        return [];
    }
}
