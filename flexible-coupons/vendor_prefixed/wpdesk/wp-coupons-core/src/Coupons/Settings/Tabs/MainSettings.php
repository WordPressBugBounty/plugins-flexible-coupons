<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Header;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Paragraph;
use FlexibleCouponsVendor\WPDesk\Forms\Field\ToggleField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\AddonField;
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
final class MainSettings extends FieldSettingsTab
{
    private $renderer;
    /** @var string field names */
    private const FIELD_AUTOMATIC_SENDING = 'automatic_sending';
    private const EXPIRY_DATE_FORMAT_FIELD = 'expiry_date_format';
    private const PRODUCT_PAGE_POSITION_FIELD = 'coupon_product_position';
    private const WPML_SUPPORT = 'wpml_support';
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
    /**
     * @return array|Field[]
     */
    protected function get_fields(): array
    {
        $is_pl = 'pl_PL' === get_locale();
        $fields = [(new Header())->set_label(esc_html__('Automatic Coupon Generation', 'flexible-coupons'))->set_description(sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            __('Read more in the %1$splugin documentation →%2$s', 'flexible-coupons'),
            sprintf('<a href="%s" target="_blank" class="docs-link">', esc_url(Links::get_doc_link())),
            '</a><br/>'
        ))->add_class('marketing-content'), (new SelectField())->set_options($this->get_wc_order_statuses())->set_name(self::FIELD_AUTOMATIC_SENDING)->set_label(\esc_html__('Automatically generate coupons', 'flexible-coupons'))->set_description(\esc_html__('If you want the coupon to be generated automatically, select order status. Coupon will be generated and sent automatically when order status is changed to selected status.', 'flexible-coupons'))->set_required()->add_class('form-table-field'), (new Paragraph())->set_name('php-allow')->set_label(\esc_html__('Allow URL Fopen', 'flexible-coupons'))->set_description($this->get_php_settings_message()), (new Header())->set_label(esc_html__('Display Formating', 'flexible-coupons')), (new DisableFieldProAdapter('', (new AddonField())->set_link(Links::get_pro_link())->set_is_addon(\false)->set_label('Upgrade to PRO')->set_description(__('Upgrade to PRO and enable options below', 'flexible-coupons'))))->get_field(), (new DisableFieldProAdapter(self::EXPIRY_DATE_FORMAT_FIELD, (new InputTextField())->set_name('')->set_label(\esc_html__('Expiry date format', 'flexible-coupons'))->set_description(sprintf(__('Define coupon expiry date format according to %1$sWordPress date formatting%2$s.', 'flexible-coupons'), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>'))->set_default_value(get_option('date_format'))->add_class('form-table-field')))->get_field(), (new DisableFieldProAdapter(self::PRODUCT_PAGE_POSITION_FIELD, (new SelectField())->set_options(['below' => \esc_html__('Below Add to cart button', 'flexible-coupons'), 'above' => \esc_html__('Above Add to cart button', 'flexible-coupons')])->set_name('')->set_label(\esc_html__('Coupon fields position on the product page', 'flexible-coupons'))->set_description(\esc_html__('Select where the coupon fields will be displayed on the product page.', 'flexible-coupons'))->add_class('form-table-field')))->get_field(), (new ToggleField())->set_sublabel(esc_html__('Enable', 'flexible-coupons'))->set_name(self::WPML_SUPPORT)->set_label(esc_html__('Enable WPML support', 'flexible-coupons'))->set_description(esc_html__('Enable conversion of coupon value to order currency', 'flexible-coupons')), (new NoOnceField(SettingsForm::NONCE_ACTION))->set_name(SettingsForm::NONCE_NAME), (new SubmitField())->set_name('save_settings')->set_label(\esc_html__('Save Changes', 'flexible-coupons'))->add_class('button-primary')->set_attribute('id', 'save_settings')];
        return apply_filters('fcpdf/settings/general/fields', $fields, $this->get_tab_slug());
    }
    private function get_wc_order_statuses(): array
    {
        $statuses = wc_get_order_statuses();
        unset($statuses['wc-cancelled'], $statuses['wc-refunded'], $statuses['wc-failed'], $statuses['wc-checkout-draft']);
        return array_merge([\esc_html__('Do not generate', 'flexible-coupons')], $statuses);
    }
    private function is_allow_url_fopen_active(): bool
    {
        return (bool) \ini_get('allow_url_fopen');
    }
    private function get_php_settings_message(): string
    {
        $is_active = $this->is_allow_url_fopen_active();
        return $this->renderer->render('allow-url-fopen-status', ['status' => $is_active ? \__('Enabled', 'flexible-coupons') : \__('Disabled', 'flexible-coupons'), 'color' => $is_active ? 'green' : 'red']);
    }
    /**
     * @return string
     */
    public static function get_tab_slug(): string
    {
        return 'general';
    }
    /**
     * @return string
     */
    public function get_tab_name(): string
    {
        return \esc_html__('Main settings', 'flexible-coupons');
    }
}
