<?php

namespace WPDesk\FlexibleCoupons\Marketing;

use FlexibleCouponsVendor\WPDesk\Library\Marketing\Boxes\Assets;
use FlexibleCouponsVendor\WPDesk\Library\Marketing\Boxes\MarketingBoxes;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FlexibleCouponsVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FlexibleCouponsVendor\WPDesk\View\Resolver\ChainResolver;
use FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver;
use FlexibleCouponsVendor\WPDesk\Library\Marketing\RatePlugin\RateBox;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;

class SupportMenuPage implements Hookable {

	const SCRIPTS_VERSION = 2;
	const PLUGIN_SLUG     = 'flexible-coupons';

	/**
	 * @var Renderer
	 */
	private $renderer;

	public function __construct() {
		$this->init_renderer();
	}

	public function hooks() {
		add_action( 'admin_menu', function () {
			add_submenu_page(
				'edit.php?post_type=wpdesk-coupons',
				esc_html__( 'Start Here', 'flexible-coupons' ),
				'<span style="color: #00FFC2">' . esc_html__( 'Start Here', 'flexible-coupons' ) . '</span>',
				'manage_options',
				'wpdesk-fc-marketing',
				[ $this, 'render_page_action' ],
				11
			);
		}, 9999 );

		add_action( 'admin_footer', [ $this, 'append_plugin_rate' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		Assets::enqueue_assets();
		Assets::enqueue_owl_assets();
	}

	/**
	 * Init renderer.
	 */
	private function init_renderer() {
		$resolver = new ChainResolver();
		$resolver->appendResolver( new DirResolver( __DIR__ . '/Views/' ) );
		$this->renderer = new SimplePhpRenderer( $resolver );
	}

	public function render_page_action() {
		$local = get_locale();
		if ( $local === 'en_US' ) {
			$local = 'en';
		}
		$boxes = new MarketingBoxes( self::PLUGIN_SLUG, $local );
		echo $this->renderer->render( 'marketing-page', [ 'boxes' => $boxes ] );
	}

	/**
	 * @return bool
	 */
	private function should_show_rate_notice(): bool {
		global $current_screen;

		return $current_screen->post_type === 'wpdesk-coupons';
	}

	/**
	 * Add plugin rate box to settings & support page
	 */
	public function append_plugin_rate() {
		if ( $this->should_show_rate_notice() ) {
			$rate_box = new RateBox();
			echo $this->renderer->render( 'rate-box-footer', [ 'rate_box' => $rate_box ] );
		}
	}

	/**
	 * @param string $screen_id
	 */
	public function admin_enqueue_scripts( $screen_id ) {
		if ( in_array( $screen_id, [ 'wpdesk-coupons_page_wpdesk-marketing' ], true ) ) {
			wp_enqueue_style( 'wpdesk-marketing', plugin_dir_url( __FILE__ ) . 'assets/css/marketing.css', [], self::SCRIPTS_VERSION );
			wp_enqueue_style( 'wpdesk-modal-marketing', plugin_dir_url( __FILE__ ) . 'assets/css/modal.css', [], self::SCRIPTS_VERSION );
			wp_enqueue_script( 'wpdesk-marketing', plugin_dir_url( __FILE__ ) . 'assets/js/modal.js', [ 'jquery' ], self::SCRIPTS_VERSION, true );
		}
	}

}
