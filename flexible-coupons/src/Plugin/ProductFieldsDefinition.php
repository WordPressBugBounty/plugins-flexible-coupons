<?php
/**
 * Product fields.
 *
 * @package WPDesk\FlexibleCouponsPro
 */

namespace WPDesk\FlexibleCoupons;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\ProductFields;

/**
 * Define inactive pro fields for coupon product.
 *
 * @package WPDesk\FlexibleCouponsPro
 */
class ProductFieldsDefinition implements ProductFields {

	/**
	 * @return array
	 */
	public function get() {
		return [
			'flexible_coupon_recipient_name'    => [
				'id'          => 'flexible_coupon_recipient_name',
				'type'        => 'text',
				'title'       => __( 'Recipient name', 'flexible-coupons' ),
				'value'       => '',
				'required'    => true,
				'validation'  => [
					'minlength' => 2,
					'maxlength' => 100,
				],
				'can_disable' => true,
			],
			'flexible_coupon_recipient_email'   => [
				'id'          => 'flexible_coupon_recipient_email',
				'type'        => 'text',
				'title'       => __( 'Recipient email', 'flexible-coupons' ),
				'value'       => '',
				'required'    => true,
				'validation'  => [
					'email'     => true,
					'minlength' => 5,
					'maxlength' => 120,
				],
				'can_disable' => true,
			],
			'flexible_coupon_recipient_message' => [
				'id'          => 'flexible_coupon_recipient_message',
				'type'        => 'textarea',
				'title'       => __( 'Recipient message', 'flexible-coupons' ),
				'value'       => '',
				'required'    => true,
				'validation'  => [
					'minlength' => 5,
					'maxlength' => 255,
				],
				'can_disable' => true,
			],
		];
	}

	public function is_premium() {
		return false;
	}

}
