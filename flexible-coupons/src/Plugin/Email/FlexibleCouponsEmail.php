<?php

namespace WPDesk\FlexibleCoupons\Email;

use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Email\FlexibleCouponsBaseEmail;

/**
 * Register email for coupon.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class FlexibleCouponsEmail extends FlexibleCouponsBaseEmail {

	/**
	 * @param string $plugin_path Plugin template path.
	 */
	public function __construct( $template_path ) {
		$this->id             = 'coupon_buyer_email';
		$this->title          = esc_html__( 'Coupon for buyer (Flexible Coupons)', 'flexible-coupons' );
		$this->description    = esc_html__( 'This message goes to the coupon buyer.', 'flexible-coupons' );
		$this->heading        = esc_html__( 'Coupon', 'flexible-coupons' );
		$this->subject        = esc_html__( '[{site_title}] You have received a coupon', 'flexible-coupons' );
		$this->template_html  = 'emails/coupon.php';
		$this->template_plain = 'emails/plain/coupon.php';
		parent::__construct( $template_path );
		$this->enabled = 'yes';
	}

	public function get_recipient(): string {

		$this->recipient = $this->object->get_billing_email();

		// run it through the WC_Email filter.
		return parent::get_recipient();
	}
}
