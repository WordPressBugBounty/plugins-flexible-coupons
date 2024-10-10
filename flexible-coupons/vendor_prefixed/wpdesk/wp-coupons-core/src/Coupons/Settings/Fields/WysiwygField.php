<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
/**
 * Define custom wysiwyg field.
 *
 * @package WPDesk\Library\WPCoupons\Settings\Fields
 */
class WysiwygField extends Field\WyswigField
{
    /**
     * @return string
     */
    public function get_template_name()
    {
        return 'wysiwyg';
    }
    /**
     * @return false
     */
    public function should_override_form_template(): bool
    {
        return \false;
    }
}
