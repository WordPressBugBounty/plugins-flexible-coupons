<?php

namespace FlexibleCouponsVendor;

global $post;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Plugin;
$params = isset($params) ? (array) $params : [];
/**
 * @var \WPDesk\Library\WPCoupons\Integration\PostMeta $post_meta
 */
$post_meta = $params['post_meta'];
/**
 * @var Renderer $renderer
 */
$loop = $params['loop'];
$renderer = $params['renderer'];
$nonce_name = $params['nonce_name'];
$nonce_action = $params['nonce_action'];
$product_fields = $params['product_fields'];
$is_premium = $params['is_premium'];
$product_templates = $params['product_templates'];
$custom_attributes = $params['custom_attributes'];
$post_id = (int) $params['post_id'];
$parent_id = (int) $params['parent_id'];
$settings = $params['settings'];
$is_pl = 'pl_PL' === \get_locale();
$pro_url = $is_pl ? 'https://www.wpdesk.pl/sklep/flexible-coupons-woocommerce/?utm_source=flexible-coupons-product-edition&amp;utm_medium=link&amp;utm_campaign=flexible-coupons-pro' : 'https://www.wpdesk.net/products/flexible-coupons-woocommerce/?utm_source=flexible-coupons-product-edition&amp;utm_medium=link&amp;utm_campaign=flexible-coupons-pro';
$docs_url = $is_pl ? 'https://www.wpdesk.pl/docs/flexible-coupons-pro/?utm_source=flexible-coupons-settings&utm_medium=link&utm_campaign=flexible-coupons-docs-link&utm_content=edit-simple-product#edycja-produktu' : 'https://www.wpdesk.net/docs/flexible-coupons-pro/?utm_source=flexible-coupons-settings&utm_medium=link&utm_campaign=flexible-coupons-docs-link&utm_content=edit-simple-product#Product_edit_screen';
$style = 'display: none;';
$is_enabled = 'yes' === \get_post_meta($post_id, '_flexible_coupon_variation_base_on', \true);
if ($is_enabled) {
    $style = 'display: block !important;';
}
?>

<div id="pdfcoupon_product_data_variation" class="show_if_variation_manage_coupons" style="<?php 
echo $style;
?>">

	<p class="form-field fc_coupon_code_field coupon-code-settings">
		<label for="fc_coupon_code">
			<?php 
\printf(
    /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
    \esc_html__('Read the %1$splugin documentation →%2$s', 'flexible-coupons'),
    '<a href="' . \esc_url($docs_url . '&utm_content=edit-product') . '" target="_blank" class="docs-link">',
    '</a>'
);
?>
		</label>
	</p>

	<div class="fc-options-group">
	<?php 
\wp_nonce_field($nonce_action, $nonce_name);
$renderer->output_render('fields/disable-pdf-coupon', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes, 'settings' => $settings]);
$renderer->output_render('fields/product-template', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'product_templates' => $product_templates]);
?>
	</div>
	<div class="fc-options-group fc-custom-fields-group">
		<?php 
if (!$is_premium) {
    echo '<p class="form-field marketing-content">';
    \printf(
        /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
        \esc_html__('%1$sUpgrade to PRO →%2$s and enable options below', 'flexible-coupons'),
        \sprintf('<a href="%s" target="_blank" class="pro-link">', \esc_url($pro_url) . '&utm_content=edit-product'),
        '</a>'
    );
    echo '</p>';
}
$renderer->output_render('fields/coupon-code-enable', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes, 'settings' => $settings]);
$style = 'display: none;';
$is_enabled = 'yes' === $post_meta->get_private($post_id, 'flexible_coupon_coupon_code', $post_meta->get_private($parent_id, 'flexible_coupon_coupon_code', 'no'));
if ($is_enabled) {
    $style = 'display: block !important;';
}
?>
		<div class="show_if_variation_manage_prefix" style="<?php 
echo $style;
?>">
			<?php 
$renderer->output_render('fields/coupon-code-prefix', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes, 'settings' => $settings]);
$renderer->output_render('fields/coupon-code-length', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes, 'settings' => $settings]);
$renderer->output_render('fields/coupon-code-suffix', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes, 'settings' => $settings]);
?>
		</div>
		<?php 
$renderer->output_render('fields/product-fields', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'product_fields' => $product_fields, 'custom_attributes' => $custom_attributes]);
?>
	</div>
	<div class="fc-options-group">
		<?php 
$renderer->output_render('fields/usage-limit', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop, 'custom_attributes' => $custom_attributes]);
$is_sending = \FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Plugin::is_fcs_pro_addon_enabled();
if (!$is_sending) {
    echo '<p class="form-field marketing-content">';
    \printf(
        /* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
        \esc_html__('Buy %1$sFlexible PDF Coupons PRO - Advanced Sending →%2$s and enable options below', 'flexible-coupons'),
        \sprintf('<a href="%s" target="_blank" class="sending-link">', \esc_url(\FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Helpers\Links::get_fcs_link()) . '&utm_content=&utm_content=edit-variations'),
        '</a>'
    );
    echo '</p>';
}
$renderer->output_render('fields/delay-type', ['post_meta' => $post_meta, 'post_id' => $post_id, 'is_sending' => $is_sending, 'loop' => $loop]);
?>
		<div class="show_if_simple_delay">
			<?php 
$renderer->output_render('fields/delay-interval', ['post_meta' => $post_meta, 'post_id' => $post_id, 'is_sending' => $is_sending, 'loop' => $loop]);
$renderer->output_render('fields/delay-value', ['post_meta' => $post_meta, 'post_id' => $post_id, 'is_sending' => $is_sending, 'loop' => $loop]);
?>
		</div>
		<div class="show_if_fixed_date_delay">
			<?php 
$renderer->output_render('fields/delay-fixed-date', ['post_meta' => $post_meta, 'post_id' => $post_id, 'is_sending' => $is_sending, 'loop' => $loop]);
?>
		</div>
			<?php 
$renderer->output_render('fields/expiring-date', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop]);
$renderer->output_render('fields/expiring-date-own', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop]);
$renderer->output_render('fields/free-shipping', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop]);
$renderer->output_render('fields/include-products', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop]);
$renderer->output_render('fields/include-categories', ['post_meta' => $post_meta, 'post_id' => $post_id, 'parent_id' => $parent_id, 'is_premium' => $is_premium, 'loop' => $loop]);
?>
	</div>
</div>
<?php 
