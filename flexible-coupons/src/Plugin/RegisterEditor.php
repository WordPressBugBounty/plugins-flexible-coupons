<?php
/**
 * Integration. Coupon editor implementation.
 *
 * @package WPDesk\FlexibleCouponsPDF
 */

namespace WPDesk\FlexibleCoupons;

use FlexibleCouponsVendor\WPDesk\Library\WPCanvaEditor\EditorImplementation;

/**
 * Integrate with editor library.
 *
 * @package WPDesk\Library\WPCoupons\Integration
 */
class RegisterEditor extends EditorImplementation {

	/**
	 * Define arguments for editor post type.
	 *
	 * @return array
	 */
	public function post_type_args_definition() {
		$labels = [
			'name'               => __( 'PDF Coupons', 'flexible-coupons' ),
			'singular_name'      => __( 'PDF Coupons', 'flexible-coupons' ),
			'menu_name'          => __( 'PDF Coupons', 'flexible-coupons' ),
			'name_admin_bar'     => __( 'PDF Coupons', 'flexible-coupons' ),
			'add_new'            => __( 'Add New', 'flexible-coupons' ),
			'add_new_item'       => __( 'Add New', 'flexible-coupons' ),
			'new_item'           => __( 'New', 'flexible-coupons' ),
			'edit_item'          => __( 'Edit', 'flexible-coupons' ),
			'view_item'          => __( 'Views', 'flexible-coupons' ),
			'all_items'          => __( 'Templates', 'flexible-coupons' ),
			'search_items'       => __( 'Search', 'flexible-coupons' ),
			'parent_item_colon'  => __( 'Parent:', 'flexible-coupons' ),
			'not_found'          => __( 'No found.', 'flexible-coupons' ),
			'not_found_in_trash' => __( 'No found in Trash.', 'flexible-coupons' ),
		];
		$args   = [
			'labels'             => $labels,
			'description'        => __( 'Manage coupons templates.', 'flexible-coupons' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'show_in_menu'       => true,
			'supports'           => [ 'title' ],
			'show_in_rest'       => false,
			'menu_icon'          => 'dashicons-tickets-alt',
		];

		return $args;
	}
}
