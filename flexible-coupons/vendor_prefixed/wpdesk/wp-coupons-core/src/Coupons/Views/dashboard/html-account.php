<?php

namespace FlexibleCouponsVendor;

$coupons = isset($params['coupons']) ? $params['coupons'] : '';
if (!empty($coupons)) {
    ?>
<section class="woocommerce-coupons-file">
	<h2 class="woocommerce-column__title"><?php 
    \esc_html_e('PDF Coupons', 'flexible-coupons');
    ?></h2>
	<?php 
    foreach ($coupons as $coupon) {
        ?>
	<p>
		<a href="<?php 
        echo $coupon['download_url'];
        ?>"><?php 
        echo $coupon['product_name'];
        ?></a> (<?php 
        echo $coupon['coupon_code'];
        ?>)
	</p>
	<?php 
    }
    ?>
</section>
<?php 
}