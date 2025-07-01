<?php

namespace FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Tabs;

use FlexibleCouponsVendor\WPDesk\Forms\Field;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Header;
use FlexibleCouponsVendor\WPDesk\Forms\Field\NoOnceField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\SubmitField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\EmailStrings;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\SettingsForm;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\LinkField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\WysiwygField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldProAdapter;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\MultipleInputTextField;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\DisableFieldSendingAddonAdapter;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Settings\Fields\CouponEmailTemplatesList;
/**
 * Main Settings Tab Page.
 *
 * @package WPDesk\Library\WPCoupons\Settings\Tabs
 */
class EmailSettings extends FieldSettingsTab
{
    /** @var string field names */
    const ATTACH_COUPON_FIELD = 'attach_coupon';
    /**
     * @return array|Field[]
     */
    protected function get_fields(): array
    {
        $is_pl = 'pl_PL' === get_locale();
        $precise_docs = $is_pl ? '&utm_content=emails-settings#emaile' : '&utm_content=emails-settings#Emails';
        $fields = [(new Header())->set_label('')->set_description(sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            __('Read more in the %1$splugin documentation →%2$s', 'flexible-coupons'),
            sprintf('<a href="%s" target="_blank" class="docs-link">', esc_url(Links::get_doc_link() . $precise_docs)),
            '</a><br/>'
        ))->add_class('marketing-content'), (new Header())->set_name('')->set_label(\esc_html__('Email settings', 'flexible-coupons'))->set_description(__('For more specific email delay settings, visit the product edit page.', 'flexible-coupons')), (new DisableFieldProAdapter('', (new LinkField())->set_label(sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            __('%1$sUpgrade to PRO →%2$s and enable options below', 'flexible-coupons'),
            sprintf('<a href="%s" target="_blank" class="pro-link">', esc_url(Links::get_pro_link() . '&utm_content=emails-settings')),
            '</a>'
        ))))->get_field(), (new DisableFieldProAdapter(self::ATTACH_COUPON_FIELD, (new CheckboxField())->set_name('')->set_label(\esc_html__('Attachments in the e-mail', 'flexible-coupons'))->set_sublabel(\esc_html__('Attach PDF file to coupon email', 'flexible-coupons'))))->get_field(), (new NoOnceField(SettingsForm::NONCE_ACTION))->set_name(SettingsForm::NONCE_NAME), (new SubmitField())->set_attribute('id', 'save_settings')->set_name('save_settings')->set_label(\esc_html__('Save Changes', 'flexible-coupons'))->add_class('button-primary'), (new DisableFieldSendingAddonAdapter('', (new LinkField())->set_label(sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            __('Buy %1$sFlexible PDF Coupons PRO - Advanced Sending →%2$s and enable options below', 'flexible-coupons'),
            sprintf('<a href="%s" target="_blank" class="sending-link">', esc_url(Links::get_fcs_link() . '&utm_content=emails-settings')),
            '</a>'
        ))))->get_field(), (new DisableFieldProAdapter('', (new LinkField())->set_label(sprintf(
            /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
            __('%1$sGet Flexible Coupons PRO with add-ons in one Bundle →%2$s', 'flexible-coupons'),
            sprintf('<a href="%s" target="_blank" class="pro-link">', esc_url(Links::get_bundle_link() . '&utm_content=emails-settings')),
            '</a>'
        ))->add_class('pro-link-wrapper')))->get_field(), (new DisableFieldSendingAddonAdapter('', (new CouponEmailTemplatesList())->set_name('')->set_label(esc_html__('Email templates', 'flexible-coupons'))))->get_field()];
        return \apply_filters('fcpdf/settings/general/fields', $fields, $this->get_tab_slug());
    }
    /**
     * @return string
     */
    public static function get_tab_slug(): string
    {
        return 'emails';
    }
    /**
     * @return string
     */
    public function get_tab_name(): string
    {
        return __('Emails', 'flexible-coupons');
    }
}
