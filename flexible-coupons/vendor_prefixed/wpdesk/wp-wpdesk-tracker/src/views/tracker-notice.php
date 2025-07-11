<?php

namespace FlexibleCouponsVendor;

if (!\defined('ABSPATH')) {
    exit;
}
?>

<div id="wpdesk_tracker_notice" class="updated notice wpdesk_tracker_notice is-dismissible">
	<p>
		<?php 
$notice_content = \apply_filters('wpdesk_tracker_notice_content', \false, $username, $terms_url);
?>
		<?php 
if (empty($notice_content)) {
    ?>
			<?php 
    \printf(\esc_html__('Hey %s,', 'flexible-coupons'), \esc_html($username));
    ?><br/>
			<?php 
    echo \wp_kses_post(\__('We need your help to improve <strong>WP Desk plugins</strong>, so they are more useful for you and the rest of <strong>30,000+ users</strong>. By collecting data on how you use our plugins, you will help us a lot. We will not collect any sensitive data, so you can feel safe.', 'flexible-coupons'));
    ?>
			<a href="<?php 
    echo \esc_url($terms_url);
    ?>" target="_blank"><?php 
    \esc_html_e('Find out more &raquo;', 'flexible-coupons');
    ?></a>
		<?php 
} else {
    ?>
			<?php 
    echo \wp_kses_post($notice_content);
    ?>
		<?php 
}
?>
	</p>
	<p>
		<button id="wpdesk_tracker_allow_button_notice" class="button button-primary"><?php 
\esc_html_e('Enable usage tracking', 'flexible-coupons');
?></button>
	</p>
</div>
<?php 
