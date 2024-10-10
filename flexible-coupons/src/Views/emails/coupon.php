<?php
/**
 * Email with a coupon.
 *
 * @var WC_Order                                                             $order
 * @var string                                                               $email_heading
 * @var \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Data\Email\EmailMeta $meta
 * @var bool                                                                 $email
 * @var int                                                                  $order_number
 * @var string                                                               $date_order
 * @var bool                                                                 $sent_to_admin
 * @var bool                                                                 $plain_text
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<h1>
	<?php
		printf(
			/* translators: %s: Customer full name. */
			esc_html__( 'Hi %s,', 'flexible-coupons' ),
			esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() )
		);
		?>
</h1>
<p><b>
	<?php
		printf(
			/* translators: %1$s: Order number. %2$s: Order date. */
			esc_html__( 'In response to an order %1$s placed %2$s, we are sending you a coupon for shopping in our shop.', 'flexible-coupons' ),
			esc_html( $order_number ),
			esc_html( $date_order )
		);
		?>
</b></p>

<p><a href="<?php echo esc_url( $meta->get_coupon_url() ); ?>"><?php esc_html_e( 'Download PDF with the coupon &raquo;', 'flexible-coupons' ); ?></a></p>

<?php if ( '' !== $meta->get_coupon_code() ) : ?>
	<p>
		<?php
			printf(
				/* translators: %s: Coupon code. */
				esc_html__( 'Coupon code: %s', 'flexible-coupons' ),
				esc_html( $meta->get_coupon_code() )
			);
		?>
	</p>
	<p>
		<?php
			printf(
				/* translators: %s: Coupon value. */
				esc_html__( 'Coupon value: %s', 'flexible-coupons' ),
				$meta->get_coupon_value() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		?>
	</p>
	<?php if ( '' !== $meta->get_coupon_expiry() ) : ?>
		<p>
			<?php
				printf(
					/* translators: %s: Coupon expiry date. */
					esc_html__( 'Expiry date: %s', 'flexible-coupons' ),
					esc_html( $meta->get_coupon_expiry() )
				);
			?>
		</p>
	<?php endif; ?>
<?php endif; ?>

<p><?php esc_html_e( 'Thanks for reading!', 'flexible-coupons' ); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>
