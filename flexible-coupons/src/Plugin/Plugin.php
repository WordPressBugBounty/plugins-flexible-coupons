<?php
/**
 * Plugin main class.
 *
 * @package WPDesk\FlexibleCoupons
 */

namespace WPDesk\FlexibleCoupons;

use FlexibleCouponsVendor\Psr\Log\LoggerAwareTrait;
use FlexibleCouponsVendor\Psr\Log\LoggerAwareInterface;
use WPDesk\FlexibleCoupons\Tracker\Tracker;
use FlexibleCouponsVendor\WPDesk_Plugin_Info;
use WPDesk\FlexibleCoupons\Email\RegisterEmails;
use WPDesk\FlexibleCoupons\Marketing\SupportMenuPage;
use WPDesk\FlexibleCoupons\ReviewNotice\ReviewNotice;
use WPDesk\FlexibleCoupons\ReviewNotice\TwoWeeksNotice;
use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\Dashboard\DashboardWidget;
use FlexibleCouponsVendor\WPDesk\Logger\SimpleLoggerFactory;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\Activateable;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use FlexibleCouponsVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\Integration\SampleTemplates;

/**
 * Main plugin class. The most important flow decisions are made here.
 *
 * @package WPDesk\FlexibleCoupons
 */
class Plugin extends AbstractPlugin implements LoggerAwareInterface, HookableCollection, Activateable {
	use LoggerAwareTrait;
	use HookableParent;

	/**
	 * @var string
	 */
	private $plugin_path;

	/**
	 * @var Renderer
	 */
	private $renderer;

	/**
	 * @var string
	 */
	private $scripts_version = '1.0';

	/**
	 * @var string
	 */
	private $upgrade_to_pro_url;

	/**
	 * @var string
	 */
	private $start_here_url;

	public const EDITOR_POST_TYPE = 'wpdesk-coupons';

	private const LOGGER_CHANNEL = 'flexible-coupons';

	/**
	 * Plugin constructor.
	 *
	 * @param WPDesk_Plugin_Info $plugin_info Plugin info.
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info ) {
		parent::__construct( $plugin_info );

		$this->plugin_info      = $plugin_info;
		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_path      = $this->plugin_info->get_plugin_dir();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();

		$is_pl                    = 'pl_PL' === get_locale();
		$this->settings_url       = admin_url( 'edit.php?post_type=' . self::EDITOR_POST_TYPE . '&page=fc-settings' );
		$this->docs_url           = $is_pl ? 'https://www.wpdesk.pl/sk/flexible-coupons-free-docs-pl/' : 'https://www.wpdesk.net/sk/flexible-coupons-free-docs-en/';
		$this->support_url        = $is_pl ? 'https://www.wpdesk.pl/sk/flexible-coupons-free-support-pl/' : 'https://www.wpdesk.net/sk/flexible-coupons-free-support-en/';
		$this->upgrade_to_pro_url = $is_pl ? 'https://www.wpdesk.pl/sk/flexible-coupons-free-pro-pl' : 'https://flexiblecoupons.net/sk/flexible-coupons-free-pro-en';
		$this->start_here_url     = admin_url( 'edit.php?post_type=wpdesk-coupons&page=wpdesk-fc-marketing' );
	}

	/**
	 * Initializes plugin external state.
	 * The plugin internal state is initialized in the constructor and the plugin should be internally consistent after
	 * creation. The external state includes hooks execution, communication with other plugins, integration with WC
	 * etc.
	 *
	 * @return void
	 */
	public function init() {
		$this->setLogger(
			( new SimpleLoggerFactory( self::LOGGER_CHANNEL ) )->getLogger()
		);
		$this->hooks();
	}

	/**
	 * @return void
	 */
	public function hooks() {
		parent::hooks();

		$editor = new RegisterEditor( self::EDITOR_POST_TYPE );
		$coupon = new CouponIntegration(
			$editor,
			$this->plugin_info->get_version(),
			$this->logger
		);
		$this->add_hookable( $editor );
		$this->add_hookable( $coupon );
		$this->add_hookable( new RegisterEmails( $this->plugin_info ) );
		$this->add_hookable( new Tracker() );
		$this->add_hookable( new SupportMenuPage() );

		add_action(
			'woocommerce_init',
			function () {
				if ( is_admin() ) {
					( new ReviewNotice(
						[ new TwoWeeksNotice( $this->plugin_url . '/assets' ) ]
					) )->hooks();
				}
			}
		);

		$this->hooks_on_hookable_objects();

		( new DashboardWidget() )->hooks();
	}

	/**
	 * Plugin activation.
	 */
	public function activate() {
		$post = new SampleTemplates( self::EDITOR_POST_TYPE );
		$post->create();
	}

	/**
	 * Links filter.
	 *
	 * @param array $links Links.
	 *
	 * @return array
	 */
	public function links_filter( $links ) {
		$plugin_links = [];

		$plugin_links[] = '<a style="font-weight:700; color: #007050" href="' . esc_url( $this->start_here_url ) . '">' . __( 'Start Here', 'flexible-coupons' ) . '</a>';
		$plugin_links[] = '<a href="' . esc_url( $this->settings_url ) . '">' . __( 'Settings', 'flexible-coupons' ) . '</a>';
		$plugin_links[] = '<a href="' . esc_url( $this->docs_url ) . '" target="_blank">' . __( 'Docs', 'flexible-coupons' ) . '</a>';
		$plugin_links[] = '<a style="font-weight:700; color: #FF9743" href="' . esc_url( $this->upgrade_to_pro_url ) . '" target="_blank">' . __( 'Upgrade to PRO', 'flexible-coupons' ) . ' →</a>';

		if ( array_key_exists( 'deactivate', $links ) ) {
			$plugin_links[] = $links['deactivate'];
		}

		return $plugin_links;
	}
}
