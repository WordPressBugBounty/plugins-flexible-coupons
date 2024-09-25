<?php
/**
 * Plugin Name: Flexible PDF Coupons for WooCommerce
 * Plugin URI: https://www.wpdesk.net/products/flexible-coupons/
 * Description: Flexible PDF Coupons for WooCommerce is a WooCommerce plugin with which you can create your gift cards, vouchers, or coupons in PDF format. Use it for your future marketing campaigns.
 * Product: Flexible PDF Coupons for WooCommerce
 * Version: 1.9.14
 * Author: WP Desk
 * Author URI: https://www.wpdesk.net/
 * Text Domain: flexible-coupons
 * Domain Path: /lang/
 * Requires at least: 5.8
 * Requires at least: 5.8
 * Tested up to: 6.6
 * WC requires at least: 8.8
 * WC tested up to: 9.2
 * Requires PHP: 7.4
 * Copyright 2017 WP Desk Ltd.
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @package WPDesk\FlexibleCoupons
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/* Plugin version */
$plugin_version = '1.9.14';
/* Plugin release */
$plugin_release_timestamp = '2023-06-21 15:45';

$plugin_name        = 'Flexible PDF Coupons for WooCommerce';
$product_id         = 'Flexible PDF Coupons for WooCommerce';
$plugin_class_name  = '\WPDesk\FlexibleCoupons\Plugin';
$plugin_text_domain = 'flexible-coupons';
$plugin_file        = __FILE__;
$plugin_dir         = dirname( __FILE__ );

/** Dummy plugin name and description - for translations only. */
$dummy_name       = __( 'Flexible PDF Coupons for WooCommerce', 'flexible-coupons' );
$dummy_desc       = __( 'Flexible PDF Coupons for WooCommerce is a WooCommerce plugin with which you can create your gift cards, vouchers, or coupons in PDF format. Use it for your future marketing campaigns.', 'flexible-coupons' );
$dummy_plugin_uri = __( 'https://www.wpdesk.net/products/flexible-coupons-woocommerce/', 'flexible-coupons' );
$dummy_author_uri = __( 'https://www.wpdesk.net/', 'flexible-coupons' );

$requirements = [
	'php'     => '7.4',
	'wp'      => '5.0',
	'plugins' => [
		[
			'name'      => 'woocommerce/woocommerce.php',
			'nice_name' => 'WooCommerce',
			'version'   => '4.0',
		],
	],
];

require __DIR__ . '/vendor_prefixed/wpdesk/wp-plugin-flow-common/src/plugin-init-php52-free.php';