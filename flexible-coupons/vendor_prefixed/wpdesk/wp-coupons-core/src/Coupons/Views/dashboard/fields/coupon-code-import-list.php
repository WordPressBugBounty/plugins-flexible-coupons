<?php

namespace FlexibleCouponsVendor;

/**
 * Custom fields template for import select.
 *
 * @var array<string, mixed> $params
 */
$meta = $params['post_meta'];
$product_id = $params['post_id'];
$disabled = $params['disabled'];
$options = $params['options'];
$loop_id = isset($params['loop']) ? '_variation' . $params['loop'] : '';
$loop_name = isset($params['loop']) ? "_variation[{$params['loop']}]" : '';
$parent_id = isset($params['parent_id']) ? $params['parent_id'] : null;
$default = $meta->get_private($parent_id, '_product_coupon_import_id', '');
$value = $meta->get_private($product_id, '_product_coupon_import_id', $default);
$custom_attributes = [];
if ($disabled) {
    $custom_attributes = ['disabled' => 'disabled'];
}
\woocommerce_wp_select(['id' => '_product_coupon_import_id' . $loop_id, 'name' => '_product_coupon_import_id' . $loop_name, 'value' => $value, 'label' => \esc_html__('Select Import', 'flexible-coupons'), 'desc_tip' => \true, 'options' => $options, 'description' => \esc_html__('Select an import to associate coupon codes from that import with this product.', 'flexible-coupons'), 'class' => 'short', 'custom_attributes' => $custom_attributes]);
