<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\CouponsIntegration;
/**
 * Disable field adapter.
 *
 * @package WPDesk\Library\WPCoupons\Settings\Fields
 */
class DisableFieldProAdapter
{
    /**
     * @var Field\BasicField
     */
    private $field;
    /**
     * @var string
     */
    private $name;
    /**
     * @param Field $field
     */
    public function __construct(string $name, \FlexibleCouponsVendor\WPDesk\Forms\Field $field)
    {
        $this->name = $name;
        $this->field = $field;
    }
    public function get_field()
    {
        if (!\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\CouponsIntegration::is_pro()) {
            $this->field->set_disabled();
            $this->field->set_readonly();
            return $this->field;
        }
        $this->field->set_name($this->name);
        return $this->field;
    }
}