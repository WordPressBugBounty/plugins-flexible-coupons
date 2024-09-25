<?php
/**
 * Email z kuponem
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<h1><?php printf( esc_html__( 'Hi %s,', 'flexible-coupons'), $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?></h1>

<p><b><?php printf( esc_html__( 'In response to an order %s placed %s, we are sending you a coupon for shopping in our shop.', 'flexible-coupons'), $order_number, $date_order ) ; ?></b></p>

<p><a href="<?php echo $meta['coupon_url']; ?>"><?php esc_html_e( 'Download PDF with the coupon &raquo;', 'flexible-coupons'); ?></a></p>

<?php if ( isset( $meta['coupon_code'] ) ): ?>
	<p><?php printf( esc_html__( 'Coupon code: %s', 'flexible-coupons' ), $meta['coupon_code'] ); ?></p>
	<p><?php printf( esc_html__( 'Coupon value: %s', 'flexible-coupons' ), $meta['coupon_value'] ); ?></p>
	<?php if( ! empty( $meta['coupon_expiry'] ) ): ?>
	<p><?php printf( esc_html__( 'Expiry date: %s', 'flexible-coupons' ), $meta['coupon_expiry'] ); ?></p>
	<?php endif; ?>
<?php endif; ?>

<p><?php esc_html_e( 'Thanks for reading!', 'flexible-coupons'); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>
