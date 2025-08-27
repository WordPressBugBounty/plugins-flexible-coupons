<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer;
use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer\TextFieldSanitizer;
class HiddenField extends BasicField
{
    public function get_type(): string
    {
        return 'hidden';
    }
    public function get_sanitizer(): Sanitizer
    {
        return new TextFieldSanitizer();
    }
    public function get_template_name(): string
    {
        return 'input-hidden';
    }
}
