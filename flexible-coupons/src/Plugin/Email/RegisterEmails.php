<?php
/**
 * Email: Register email templates.
 *
 * WooCommerce only accept classes without namespaces.
 *
 * @package WooCommerceWFirma
 */

namespace WPDesk\FlexibleCoupons\Email;

use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FlexibleCouponsVendor\WPDesk_Plugin_Info;

/**
 * Register email templates and pass them to the WooCommerce filter.
 *
 * @package WPDesk\WooCommerceWFirma\Email
 */
class RegisterEmails implements Hookable {

	/**
	 * @var WPDesk_Plugin_Info
	 */
	private $plugin_info;

	/**
	 * @param WPDesk_Plugin_Info $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin_info = $plugin;
	}

	/**
	 * Hooks
	 */
	public function hooks() {
		add_filter( 'woocommerce_email_classes', [ $this, 'register_emails' ], 11 );
	}

	/**
	 * @return string
	 */
	private function get_template_path() {
		return $this->plugin_info->get_plugin_dir() . '/src/Views/';
	}

	/**
	 * Register emails in WooCommerce.
	 *
	 * @param array $emails Emails.
	 *
	 * @return array
	 */
	public function register_emails( array $emails ) {
		$emails[ FlexibleCouponsEmail::SLUG ] = new FlexibleCouponsEmail( $this->get_template_path() );

		return $emails;
	}

}
