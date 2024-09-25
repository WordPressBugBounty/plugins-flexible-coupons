<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;
class CallableSanitizer implements \FlexibleCouponsVendor\WPDesk\Forms\Sanitizer
{
    private $callable;
    public function __construct($callable)
    {
        $this->callable = $callable;
    }
    public function sanitize($value)
    {
        return \call_user_func($this->callable, $value);
    }
}
