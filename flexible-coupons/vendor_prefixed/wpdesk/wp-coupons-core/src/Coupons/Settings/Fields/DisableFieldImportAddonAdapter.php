<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields;

use FlexibleCouponsVendor\WPDesk\Forms\Field\BasicField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Plugin;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\CouponsIntegration;
class DisableFieldImportAddonAdapter
{
    private BasicField $field;
    private string $name;
    public function __construct(string $name, BasicField $field)
    {
        $this->name = $name;
        $this->field = $field;
    }
    /**
     * @return BasicField
     */
    public function get_field()
    {
        if (!Plugin::is_fcci_pro_addon_enabled() && CouponsIntegration::is_pro()) {
            $this->field->set_disabled();
            $this->field->set_readonly();
            return $this->field;
        }
        $this->field->set_name($this->name);
        return $this->field;
    }
}
