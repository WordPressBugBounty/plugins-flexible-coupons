<?php

namespace FlexibleCouponsVendor;

/**
 * Categories field template.
 *
 * This template can be used in simple product PDF coupon settings or variations.
 */
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\PostMeta;
$params = isset($params) ? (array) $params : [];
/**
 * @var PostMeta $meta
 */
$meta = $params['post_meta'];
$post_id = $params['post_id'];
$is_premium = $params['is_premium'];
$loop_id = isset($params['loop']) ? '_variation' . $params['loop'] : '';
$loop_name = isset($params['loop']) ? "_variation[{$params['loop']}]" : '';
$parent_id = isset($params['parent_id']) ? $params['parent_id'] : null;
// Get the parent default meta value for variable.
$default = $meta->get_private($parent_id, 'flexible_coupon_product_categories', []);
$category_ids = $meta->get_private($post_id, 'flexible_coupon_product_categories', $default);
?>
<p class="form-field">
	<label
		for="fc_product_categories<?php 
echo $loop_id;
?>"><?php 
\esc_html_e('Product categories', 'flexible-coupons');
?></label>
	<select
		id="fc_product_categories<?php 
echo $loop_id;
?>"
		name="fc_product_categories<?php 
echo $loop_name;
?>[]"
		class="wc-enhanced-select"
		style="width: 80% !important;"
		multiple="multiple" data-placeholder="<?php 
\esc_attr_e('Any category', 'flexible-coupons');
?>">
		<?php 
$categories = \get_terms('product_cat', 'orderby=name&hide_empty=0');
if ($categories) {
    foreach ($categories as $cat) {
        echo '<option value="' . \esc_attr($cat->term_id) . '" ' . \wc_selected($cat->term_id, $category_ids) . '>' . \esc_html($cat->name) . '</option>';
    }
}
?>
	</select> <?php 
echo \wc_help_tip(\esc_html__('Categories for which the coupon will be used. Do not select any to apply to all categories.', 'flexible-coupons'));
?>
</p>
<?php 
