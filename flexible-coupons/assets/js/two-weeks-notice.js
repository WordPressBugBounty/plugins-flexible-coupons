'use strict';

(function ($) {
	$(document).on('click', '.sm-close-temporary-notice, #flexible_coupons_two_week_rate_notice .notice-dismiss', function (event) {
		event.preventDefault();
		let button = this;
		$.ajax(ajaxurl,
			{
				type: 'POST',
				data: {
					action: 'flexible_coupon_close_temporary',
					source: jQuery( this ).attr( 'data-source'),
				}
			}
		).done(function() {
			$(button).parents('.notice').fadeOut();
		});
	});
})(jQuery);
