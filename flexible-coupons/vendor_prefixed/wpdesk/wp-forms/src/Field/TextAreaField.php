<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

class TextAreaField extends \FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField
{
    public function __construct()
    {
        parent::__construct();
        $this->set_default_value('');
    }
    public function get_template_name()
    {
        return 'textarea';
    }
}
