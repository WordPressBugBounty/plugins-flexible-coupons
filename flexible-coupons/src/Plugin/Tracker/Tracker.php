<?php
/**
 * Tracker. Opt out.
 */
namespace WPDesk\FlexibleCoupons\Tracker;

use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * Handle Tracker actions and filters.
 */
class Tracker implements Hookable {

	const PLUGIN_ACTION_LINKS_FILTER_NAME = 'plugin_action_links_flexible-coupons/flexible-coupons.php';
	const FLEXIBLE_COUPONS_PLUGIN_FILE    = 'flexible-coupons/flexible-coupons.php';
	const FLEXIBLE_COUPONS_PLUGIN_SLUG    = 'flexible-coupons';
	const FLEXIBLE_COUPONS_PLUGIN_TITLE   = 'Flexible coupons';

	public static $script_version = '11';

	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
		add_filter( 'wpdesk_tracker_data', array( $this, 'wpdesk_tracker_data' ), 11 );
		add_filter( 'wpdesk_tracker_notice_screens', array( $this, 'wpdesk_tracker_notice_screens' ) );
		add_filter( 'wpdesk_track_plugin_deactivation', array( $this, 'wpdesk_track_plugin_deactivation' ) );

		add_filter( self::PLUGIN_ACTION_LINKS_FILTER_NAME, array( $this, 'plugin_action_links' ), 1 );
	}

	public function wpdesk_track_plugin_deactivation( $plugins ) {
		$plugins[ self::FLEXIBLE_COUPONS_PLUGIN_FILE ] = self::FLEXIBLE_COUPONS_PLUGIN_FILE;
		return $plugins;
	}

	public function wpdesk_tracker_data( $data ) {

		return $data;
	}

	public function wpdesk_tracker_notice_screens( $screens ) {
		$current_screen = get_current_screen();
		if ( in_array( $current_screen->id, array( 'fpf_fields', 'edit-fpf_fields' ) ) ) {
			$screens[] = $current_screen->id;
		}
		return $screens;
	}

	public function plugin_action_links( $links ) {
		if ( !wpdesk_tracker_enabled() || apply_filters( 'wpdesk_tracker_do_not_ask', false ) ) {
			return $links;
		}
		$options = get_option('wpdesk_helper_options', array() );
		if ( !is_array( $options ) ) {
			$options = array();
		}
		if ( empty( $options['wpdesk_tracker_agree'] ) ) {
			$options['wpdesk_tracker_agree'] = '0';
		}
		$plugin_links = array();
		if ( $options['wpdesk_tracker_agree'] == '0' ) {
			$opt_in_link = admin_url( 'admin.php?page=wpdesk_tracker&plugin=' . self::FLEXIBLE_COUPONS_PLUGIN_FILE );
			$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-in', 'flexible-product-fields' ) . '</a>';
		}
		else {
			$opt_in_link = admin_url( 'plugins.php?wpdesk_tracker_opt_out=1&plugin=' . self::FLEXIBLE_COUPONS_PLUGIN_FILE );
			$plugin_links[] = '<a href="' . $opt_in_link . '">' . __( 'Opt-out', 'flexible-product-fields' ) . '</a>';
		}
		return array_merge( $plugin_links, $links );
	}

}

if ( ! function_exists( 'wpdesk_tracker_enabled' ) ) {
	/**
	 * Disable tracker on localhost.
	 *
	 * @return bool
	 */
	function wpdesk_tracker_enabled() {
		$tracker_enabled = true;
		if ( ! empty( $_SERVER['SERVER_ADDR'] ) && '127.0.0.1' === $_SERVER['SERVER_ADDR'] ) {
			$tracker_enabled = false;
		}
		return apply_filters( 'wpdesk_tracker_enabled', $tracker_enabled );
	}
}


