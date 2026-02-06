<?php

use FlexibleCouponsVendor\WPDesk\Library\Marketing\RatePlugin\RateBox;

/**
 * @var RateBox $boxes
 */
$rate_box = $params['rate_box'] ?? false;
if ( ! $rate_box ) {
	return;
}
?>
<script id="fi_rate_box" type="text/template">
	<?php
	$is_PL       = get_locale() === 'pl_PL' ? 'https://wpdesk.pl/sk/flexible-coupons-free-rate-pl' : 'https://wpdesk.net/sk/flexible-coupons-free-rate-en';
	$review_link = 'https://wordpress.org/support/plugin/flexible-coupons/reviews/#new-post';
	echo $rate_box->render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$review_link,
		sprintf(
			// translator: %1$s icon,  %2$s open url tag, %3$s close url tag.
			__( 'Created with %1$s by Sailors from %2$sWP Desk%3$s - if you like Flexible Coupons rate us &rarr;', 'flexible-coupons' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<span class="love"><span class="dashicons dashicons-heart"></span></span>',
			'<a target="_blank" href="' . \esc_url( $is_PL ) . '">',
			'</a>'
		)
	);
	?>
</script>
<script>
	(function ($) {
		let body_wrapper = $('#marketing-page-wrapper, #fiw-settings-footer');
		if (body_wrapper.length) {
			body_wrapper.append($('#fi_rate_box').html())
		}
	})(jQuery);
</script>
