<?php
/**
 * Email with a coupon (plain text)
 *
 * @var WC_Order                                                             $order
 * @var string                                                               $email_heading
 * @var \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Data\Email\EmailMeta $meta
 * @var bool                                                                 $email
 * @var string                                                               $order_number
 * @var string                                                               $date_order
 * @var bool                                                                 $sent_to_admin
 * @var bool                                                                 $plain_text
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

echo \esc_textarea( $email_heading );

echo PHP_EOL . PHP_EOL;

echo '****************************************************' . PHP_EOL . PHP_EOL;

printf(
	/* translators: %s: Customer full name. */
	\esc_textarea( __( 'Hi %s,', 'flexible-coupons' ) ),
	\esc_textarea( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() )
);

echo PHP_EOL . PHP_EOL;

printf(
	/* translators: %1$s: Order number. %2$s: Order date. */
	\esc_textarea( __( 'In response to an order %1$s placed %2$s, we are sending you a coupon for shopping in our shop.', 'flexible-coupons' ) ),
	\esc_textarea( $order_number ),
	\esc_textarea( $date_order )
);

echo PHP_EOL . PHP_EOL;

printf(
	\esc_textarea(
		/* translators: %s: Coupon URL. */
		__( 'Download PDF with the coupon from: %s', 'flexible-coupons' )
	),
	\esc_url( $meta->get_coupon_url() )
);

echo PHP_EOL . PHP_EOL;

echo esc_html__( 'Coupon information', 'flexible-coupons' ) . PHP_EOL;
if ( '' !== $meta->get_coupon_code() ) {
	printf(
		\esc_textarea(
			/* translators: %s: Coupon code. */
			__( 'Coupon code: %s', 'flexible-coupons' )
		),
		\esc_textarea( $meta->get_coupon_code() )
	);
	echo PHP_EOL;

	printf(
		\esc_textarea(
			/* translators: %s: Coupon value. */
			__( 'Coupon value: %s', 'flexible-coupons' )
		),
		\esc_textarea( \wp_strip_all_tags( $meta->get_coupon_value() ) )
	);
	echo PHP_EOL;

	if ( '' !== $meta->get_coupon_expiry() ) {
		printf(
			\esc_textarea(
				/* translators: %s: Coupon expiry date. */
				__( 'Expiry date: %s', 'flexible-coupons' )
			),
			\esc_textarea( $meta->get_coupon_expiry() )
		);
	}
}

echo PHP_EOL . PHP_EOL;

echo \esc_textarea( __( 'Thanks for reading!', 'flexible-coupons' ) ) . PHP_EOL . PHP_EOL;

echo '****************************************************' . PHP_EOL . PHP_EOL;

echo \esc_textarea(
	apply_filters( 'woocommerce_email_footer_text', \get_option( 'woocommerce_email_footer_text' ) )
);
