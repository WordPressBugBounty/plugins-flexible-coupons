<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;
class EmailSanitizer implements Sanitizer
{
    public function sanitize($value): string
    {
        return sanitize_email($value);
    }
}
