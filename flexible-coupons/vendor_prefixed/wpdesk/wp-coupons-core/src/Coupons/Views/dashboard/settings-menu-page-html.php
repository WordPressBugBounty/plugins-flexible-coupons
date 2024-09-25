<?php

namespace FlexibleCouponsVendor;

/**
 * Settings template.
 */
?>
<div class="wrap nosubsub">
	<h1><?php 
\esc_html_e('Settings', 'flexible-coupons');
?></h1>
	<form method="POST" action="">
		<?php 
\wp_nonce_field('save_settings', 'flexible_coupons_settings');
?>
		<?php 
if (!empty($params['fields'])) {
    echo $params['fields'];
}
\submit_button(\esc_attr__('Save', 'flexible-coupons'));
?>
	</form>
</div>
<?php 
