<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

class Paragraph extends \FlexibleCouponsVendor\WPDesk\Forms\Field\NoValueField
{
    public function get_template_name()
    {
        return 'paragraph';
    }
    public function should_override_form_template()
    {
        return \true;
    }
}