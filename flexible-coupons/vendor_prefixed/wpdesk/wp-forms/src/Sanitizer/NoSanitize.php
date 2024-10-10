<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;
class NoSanitize implements Sanitizer
{
    public function sanitize($value)
    {
        return $value;
    }
}
