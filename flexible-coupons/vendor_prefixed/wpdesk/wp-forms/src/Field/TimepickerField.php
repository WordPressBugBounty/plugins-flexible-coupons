<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Field;

class TimepickerField extends \FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField
{
    /**
     * @inheritDoc
     */
    public function get_template_name()
    {
        return 'timepicker';
    }
}
