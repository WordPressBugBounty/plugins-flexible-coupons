<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Header;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Paragraph;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\Forms\Field\NoOnceField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\SelectField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\SubmitField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\LinkField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter;
/**
 * Main Settings Tab Page.
 *
 * @package WPDesk\Library\WPCoupons\Settings\Tabs
 */
final class MainSettings extends \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs\FieldSettingsTab
{
    private $renderer;
    /** @var string field names */
    const FIELD_AUTOMATIC_SENDING = 'automatic_sending';
    const EXPIRY_DATE_FORMAT_FIELD = 'expiry_date_format';
    const PRODUCT_PAGE_POSITION_FIELD = 'coupon_product_position';
    public function __construct(\FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
    /**
     * @return array|Field[]
     */
    protected function get_fields() : array
    {
        $is_pl = 'pl_PL' === \get_locale();
        $precise_docs = $is_pl ? '&utm_content=main-settings#ustawienia-glowne' : '&utm_content=main-settings#Settings';
        $fields = [(new \FlexibleCouponsVendor\WPDesk\Forms\Field\Header())->set_label('')->set_description(\sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            \__('Read more in the %1$splugin documentation →%2$s', 'flexible-coupons'),
            \sprintf('<a href="%s" target="_blank" class="docs-link">', \esc_url(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links::get_doc_link() . $precise_docs)),
            '</a><br/>'
        ))->add_class('marketing-content'), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\SelectField())->set_name(self::FIELD_AUTOMATIC_SENDING)->set_label(\esc_html__('Automatically generate coupons', 'flexible-coupons'))->set_options($this->get_wc_order_statuses())->set_description(\esc_html__('If you want the coupon to be generated automatically, select order status. Coupon will be generated and sent automatically when order status is changed to selected status.', 'flexible-coupons'))->set_required()->add_class('form-table-field'), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter('', (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\LinkField())->set_label(\sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            \__('%1$sUpgrade to PRO →%2$s and enable options below', 'flexible-coupons'),
            \sprintf('<a href="%s" target="_blank" class="pro-link">', \esc_url(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links::get_pro_link() . '&utm_content=main-settings')),
            '</a>'
        ))))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::EXPIRY_DATE_FORMAT_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField())->set_name('')->set_label(\esc_html__('Expiry date format', 'flexible-coupons'))->set_description(\sprintf(\__('Define coupon expiry date format according to %1$sWordPress date formatting%2$s.', 'flexible-coupons'), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>'))->set_default_value(\get_option('date_format'))->add_class('form-table-field')))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter(self::PRODUCT_PAGE_POSITION_FIELD, (new \FlexibleCouponsVendor\WPDesk\Forms\Field\SelectField())->set_name('')->set_label(\esc_html__('Coupon fields position on the product page', 'flexible-coupons'))->set_options(['below' => \esc_html__('Below Add to cart button', 'flexible-coupons'), 'above' => \esc_html__('Above Add to cart button', 'flexible-coupons')])->set_description(\esc_html__('Select where the coupon fields will be displayed on the product page.', 'flexible-coupons'))->add_class('form-table-field')))->get_field(), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\Paragraph())->set_name('php-alow')->set_label(\esc_html__('Allow URL Fopen', 'flexible-coupons'))->set_description($this->get_php_settings_message()), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\NoOnceField(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm::NONCE_ACTION))->set_name(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm::NONCE_NAME), (new \FlexibleCouponsVendor\WPDesk\Forms\Field\SubmitField())->set_attribute('id', 'save_settings')->set_name('save_settings')->set_label(\esc_html__('Save Changes', 'flexible-coupons'))->add_class('button-primary')];
        return \apply_filters('fcpdf/settings/general/fields', $fields, $this->get_tab_slug());
    }
    private function get_wc_order_statuses() : array
    {
        $statuses = \wc_get_order_statuses();
        unset($statuses['wc-cancelled'], $statuses['wc-refunded'], $statuses['wc-failed'], $statuses['wc-checkout-draft']);
        return \array_merge([\esc_html__('Do not generate', 'flexible-coupons')], $statuses);
    }
    private function is_allow_url_fopen_active() : bool
    {
        return (bool) \ini_get('allow_url_fopen');
    }
    private function get_php_settings_message() : string
    {
        $is_active = $this->is_allow_url_fopen_active();
        return $this->renderer->render('allow-url-fopen-status', ['status' => $is_active ? \__('Enabled', 'flexible-coupons') : \__('Disabled', 'flexible-coupons'), 'color' => $is_active ? 'green' : 'red']);
    }
    /**
     * @return string
     */
    public static function get_tab_slug() : string
    {
        return 'general';
    }
    /**
     * @return string
     */
    public function get_tab_name() : string
    {
        return \esc_html__('Main settings', 'flexible-coupons');
    }
}