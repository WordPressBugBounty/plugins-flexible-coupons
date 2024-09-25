<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

use FlexibleCouponsVendor\WPDesk\Forms\Sanitizer\TextFieldSanitizer;
class DateField extends \FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField
{
    public function __construct()
    {
        parent::__construct();
        $this->set_placeholder('YYYY-MM-DD');
    }
    public function get_type()
    {
        return 'date';
    }
    public function get_template_name()
    {
        return 'input-text';
    }
}