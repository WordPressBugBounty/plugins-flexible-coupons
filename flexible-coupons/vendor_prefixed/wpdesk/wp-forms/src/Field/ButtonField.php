<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

class ButtonField extends \FlexibleCouponsVendor\WPDesk\Forms\Field\NoValueField
{
    public function get_template_name()
    {
        return 'button';
    }
    public function get_type()
    {
        return 'button';
    }
}
