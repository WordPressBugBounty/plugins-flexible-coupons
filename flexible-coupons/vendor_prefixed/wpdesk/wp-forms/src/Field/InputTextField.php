<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer\TextFieldSanitizer;
class InputTextField extends BasicField
{
    public function __construct()
    {
        parent::__construct();
        $this->set_default_value('');
        $this->set_attribute('type', 'text');
    }
    public function get_sanitizer()
    {
        return new TextFieldSanitizer();
    }
    public function get_template_name()
    {
        return 'input-text';
    }
}
