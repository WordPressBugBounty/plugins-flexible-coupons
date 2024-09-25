<?php
/**
 * Email z kuponem (plain text)
 */
/**
 * @var $order WC_Order
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

echo $email_heading . "\n\n";

echo "****************************************************";

echo PHP_EOL . PHP_EOL;

printf( esc_html__( 'Hi %s,', 'flexible-coupons' ), $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );

echo PHP_EOL . PHP_EOL;

printf( esc_html__( 'In response to an order %s placed %s, we are sending you a coupon for shopping in our shop.', 'flexible-coupons' ), $order_number, $date_order );

echo PHP_EOL . PHP_EOL;

printf( esc_html__( 'Download PDF with the coupon from: %s', 'flexible-coupons' ), $meta['coupon_url'] );

echo PHP_EOL . PHP_EOL;

echo esc_html__( 'Coupon information', 'flexible-coupons' ) . PHP_EOL;
if ( isset( $meta['coupon_code'] ) ) {
	printf( esc_html__( 'Coupon code: %s', 'flexible-coupons' ), $meta['coupon_code'] );
	printf( esc_html__( 'Coupon value: %s', 'flexible-coupons' ), $meta['coupon_value'] );
	if ( ! empty( $meta['coupon_expiring'] ) ) {
		printf( esc_html__( 'Expiry date: %s', 'flexible-coupons' ), $meta['coupon_expiring'] );
	}
}

echo PHP_EOL . PHP_EOL;

esc_html_e( 'Thanks for reading!', 'flexible-coupons' );

echo "****************************************************" . PHP_EOL . PHP_EOL;

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
