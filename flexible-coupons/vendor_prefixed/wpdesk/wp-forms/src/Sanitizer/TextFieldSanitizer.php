<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;
class TextFieldSanitizer implements Sanitizer
{
    public function sanitize($value)
    {
        return sanitize_text_field($value);
    }
}
