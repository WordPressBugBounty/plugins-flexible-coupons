<?php
/**
 * General settings.
 *
 * @package WPDesk\FlexibleCouponsPro
 */

namespace WPDesk\FlexibleCoupons\Settings;

use FlexibleCouponsVendor\WPDesk\Forms\Field\CheckboxField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Header;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputNumberField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\InputTextField;
use FlexibleCouponsVendor\WPDesk\Forms\Field\Paragraph;
use FlexibleCouponsVendor\WPDesk\Forms\Field\SelectField;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * Define pro fields for general settings.
 *
 * @package WPDesk\FlexibleCouponsPro
 */
class GeneralSettings implements Hookable {

	const USE_REGULAR_PRICE = 'coupon_regular_price';

	const EXPIRY_DATE_FORMAT          = 'expiry_date_format';
	const ATTACH_COUPON               = 'attach_coupon';
	const PRODUCT_PAGE_POSITION       = 'coupon_product_position';
	const SHOW_TIPS_FIELD             = 'coupon_tips';
	const SHOW_TEXTAREA_COUNTER_FIELD = 'coupon_textarea_counter';
	const COUPON_CODE_PREFIX          = 'coupon_code_prefix';
	const COUPON_CODE_SUFFIX          = 'coupon_code_suffix';
	const COUPON_CODE_LENGTH          = 'coupon_code_random_length';

	public function hooks() {
		add_filter( 'fcpdf/settings/general/fields', [ $this, 'add_pro_fields' ] );
	}

	/**
	 * @return array
	 */
	public function add_pro_fields( $fields ): array {
		$is_pl          = 'pl_PL' === get_locale();
		$pro_url        = $is_pl ? 'https://www.wpdesk.pl/sklep/flexible-coupons-woocommerce/?utm_source=flexible-coupons-product-edition&amp;utm_medium=link&amp;utm_campaign=flexible-coupons-pro' : 'https://www.wpdesk.net/products/flexible-coupons-woocommerce/?utm_source=flexible-coupons-product-edition&amp;utm_medium=link&amp;utm_campaign=flexible-coupons-pro';
		$upgrade_to_pro = '<a target="_blank" href="' . esc_url( $pro_url ) . '">' . esc_html__( 'Upgrade to PRO and enable options below →', 'flexible-coupons' ) . '</a>';
		$submit_field   = array_pop( $fields );
		$pro_fields     = [
			( new Paragraph() )
				->set_label( '' )
				->set_description(
					$upgrade_to_pro
				),
			( new InputTextField() )
				->set_name( self::EXPIRY_DATE_FORMAT )
				->set_label( esc_html__( 'Expiry date format', 'flexible-coupons' ) )
				->set_description( sprintf( __( 'Define coupon expiry date format according to %1$sWordPress date formatting%2$s.', 'flexible-coupons' ), '<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">', '</a>' ) )
				->set_default_value( get_option( 'date_format' ) )
				->set_disabled()
				->set_readonly(),
			( new CheckboxField() )
				->set_name( self::ATTACH_COUPON )
				->set_label( esc_html__( 'PDF as attachment', 'flexible-coupons' ) )
				->set_sublabel( esc_html__( 'Enable', 'flexible-coupons' ) )
				->set_description( esc_html__( 'Enable to add PDF coupons as email attachments. If this option is disabled, recipients will only be able to download the coupon via a link in the email.', 'flexible-coupons' ) )
				->set_disabled()
				->set_readonly(),
			( new SelectField() )
				->set_name( self::PRODUCT_PAGE_POSITION )
				->set_label( esc_html__( 'Coupon fields position on the product page', 'flexible-coupons' ) )
				->set_options(
					[
						'below' => esc_html__( 'Below Add to cart button', 'flexible-coupons' ),
						'above' => esc_html__( 'Above Add to cart button', 'flexible-coupons' ),
					]
				)
				->set_description( esc_html__( 'Select where the coupon fields will be displayed on the product page.', 'flexible-coupons' ) )
				->set_disabled()
				->set_readonly(),
			( new Header() )
				->set_label( esc_html__( 'Coupon code', 'flexible-coupons' ) )
				->set_description(
				// translators: %1$s start url, %2$s close url.
					sprintf( esc_html__( 'In this section you can define your own settings for coupon code.', 'flexible-coupons' ) )
				),
			( new InputTextField() )
				->set_name( self::COUPON_CODE_PREFIX )
				->set_label( esc_html__( 'Coupon code prefix', 'flexible-coupons' ) )
				->set_description( __( 'Define the prefix which will be used as a beginning of your coupon code. Leave empty if you don’t want to use the prefix. Use <code>{order_id}</code> shortcode if you want to use the order number.', 'flexible-coupons' ) )
				->set_disabled()
				->set_readonly(),
			( new InputNumberField() )
				->set_name( self::COUPON_CODE_LENGTH )
				->set_label( esc_html__( 'Number of random characters', 'flexible-coupons' ) )
				->set_description( esc_html__( 'The number of random characters in the coupon code. Random characters will be used for generating unique coupon codes. Choose the number between 5 and 30.', 'flexible-coupons' ) )
				->set_default_value( 5 )
				->set_disabled()
				->set_readonly(),
			( new InputTextField() )
				->set_name( self::COUPON_CODE_SUFFIX )
				->set_label( esc_html__( 'Coupon code suffix', 'flexible-coupons' ) )
				->set_description( __( 'Define the suffix which will be used as a end of your coupon code. Leave empty if you don’t want to use the suffix. Use <code>{order_id}</code> shortcode if you want to use the order number.', 'flexible-coupons' ) )
				->set_disabled()
				->set_readonly(),
			( new CheckboxField() )
				->set_name( self::USE_REGULAR_PRICE )
				->set_label( esc_html__( 'Coupon value', 'flexible-coupons' ) )
				->set_sublabel( esc_html__( 'Enable', 'flexible-coupons' ) )
				->set_description( esc_html__( 'Always use the regular price of the product for the coupon value.', 'flexible-coupons' ) )
				->set_disabled()
				->set_readonly(),
			( new CheckboxField() )
				->set_name( self::SHOW_TIPS_FIELD )
				->set_label( esc_html__( 'Show field tips', 'flexible-coupons-pro' ) )
				->set_sublabel( esc_html__( 'Enable', 'flexible-coupons-pro' ) )
				->set_description( esc_html__( 'Show tooltips for fields.', 'flexible-coupons-pro' ) )
				->set_disabled()
				->set_readonly(),
			( new CheckboxField() )
				->set_name( self::SHOW_TEXTAREA_COUNTER_FIELD )
				->set_label( esc_html__( 'Show textarea counter', 'flexible-coupons-pro' ) )
				->set_sublabel( esc_html__( 'Enable', 'flexible-coupons-pro' ) )
				->set_description( esc_html__( 'Show character counter below textarea.', 'flexible-coupons-pro' ) )
				->set_disabled()
				->set_readonly(),
		];

		return array_merge( $fields, $pro_fields, [ $submit_field ] );
	}

}
