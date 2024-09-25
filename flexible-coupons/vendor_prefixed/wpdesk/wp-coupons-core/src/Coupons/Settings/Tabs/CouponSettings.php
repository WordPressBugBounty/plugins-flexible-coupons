<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Header;
use FlexibleCouponsVendor\WPDesk\Forms\Field\NoOnceField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\SubmitField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputNumberField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\LinkField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter;
/**
 * Main Settings Tab Page.
 *
 * @package WPDesk\Library\WPCoupons\Settings\Tabs
 */
final class CouponSettings extends \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs\FieldSettingsTab
{
    /** @var string field names */
    const COUPON_CODE_PREFIX_FIELD = 'coupon_code_prefix';
    const COUPON_CODE_SUFFIX_FIELD = 'coupon_code_suffix';
    const REGULAR_PRICE_FIELD = 'coupon_regular_price';
    const SHOW_TIPS_FIELD = 'coupon_tips';
    const SHOW_TEXTAREA_COUNTER_FIELD = 'coupon_textarea_counter';
    const COUPON_CODE_LENGTH_FIELD = 'coupon_code_random_length';
    /**
     * @return array|Field[]
     */
    protected function get_fields() : array
    {
        $is_pl = 'pl_PL' === \get_locale();
        $precise_docs = $is_pl ? '&utm_content=coupon-settings#kupon' : '&utm_content=coupon-settings#Coupon';
        $fields = [(new \FlexibleCouponsVendor\WPDesk\Forms\Field\Header())->set_label('')->set_description(\sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            \__('Read more in the %1$splugin documentation →%2$s', 'flexible-coupons'),
            \sprintf('<a href="%s" target="_blank" class="docs-link">', \esc_url(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links::get_doc_link() . $precise_docs)),
            '</a><br/>'
        ))->add_class('marketing-content'), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter('', (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\LinkField())->set_label(\sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            \__('%1$sUpgrade to PRO →%2$s and enable options below', 'flexible-coupons'),
            \sprintf('<a href="%s" target="_blank" class="pro-link">', \esc_url(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links::get_pro_link() . '&utm_content=coupon-settings')),
            '</a>'
        ))))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::COUPON_CODE_PREFIX_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField())->set_name('')->set_label(\esc_html__('Coupon code prefix', 'flexible-coupons'))->set_description(\__('Define the prefix which will be used as a beginning of your coupon code. Leave empty if you don’t want to use the prefix. Use <code>{order_id}</code> shortcode if you want to use the order number.', 'flexible-coupons'))->add_class('form-table-field'), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::COUPON_CODE_SUFFIX_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField())->set_name('')->set_label(\esc_html__('Coupon code suffix', 'flexible-coupons'))->set_description(\__('Define the suffix which will be used as a end of your coupon code. Leave empty if you don’t want to use the suffix. Use <code>{order_id}</code> shortcode if you want to use the order number.', 'flexible-coupons'))->add_class('form-table-field'), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::COUPON_CODE_LENGTH_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\InputNumberField())->set_name('')->set_label(\esc_html__('Number of random characters', 'flexible-coupons'))->set_description(\esc_html__('The number of random characters in the coupon code. Random characters will be used for generating unique coupon codes. Choose the number between 5 and 30.', 'flexible-coupons'))->set_default_value(5)->set_attribute('min', 5)->set_attribute('max', 30)->add_class('form-table-field'), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::REGULAR_PRICE_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField())->set_name('')->set_label(\esc_html__('Coupon value', 'flexible-coupons'))->set_sublabel(\esc_html__('Enable', 'flexible-coupons'))->set_description(\esc_html__('Always use the regular price of the product for the coupon value.', 'flexible-coupons')), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::SHOW_TIPS_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField())->set_name('')->set_label(\esc_html__('Show field tips', 'flexible-coupons'))->set_sublabel(\esc_html__('Enable', 'flexible-coupons'))->set_description(\esc_html__('Show tooltips for fields.', 'flexible-coupons')), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::SHOW_TEXTAREA_COUNTER_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField())->set_name('')->set_label(\esc_html__('Show textarea counter', 'flexible-coupons'))->set_sublabel(\esc_html__('Enable', 'flexible-coupons'))->set_description(\esc_html__('Show character counter below textarea.', 'flexible-coupons')), \true))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\NoOnceField(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm::NONCE_ACTION))->set_name(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm::NONCE_NAME), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\SubmitField())->set_attribute('id', 'save_settings')->set_name('save_settings')->set_label(\esc_html__('Save Changes', 'flexible-coupons'))->add_class('button-primary')];
        return \apply_filters('fcpdf/settings/general/fields', $fields, $this->get_tab_slug());
    }
    /**
     * @return string
     */
    public static function get_tab_slug() : string
    {
        return 'coupon';
    }
    /**
     * @return string
     */
    public function get_tab_name() : string
    {
        return \esc_html__('Coupon', 'flexible-coupons');
    }
}
