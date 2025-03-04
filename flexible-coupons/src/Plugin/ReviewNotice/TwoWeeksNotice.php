<?php

namespace WPDesk\FlexibleCoupons\ReviewNotice;

use FlexibleCouponsVendor\WPDesk\Notice\Notice;
use FlexibleCouponsVendor\WPDesk\Notice\PermanentDismissibleNotice;
use FlexibleCouponsVendor\WPDesk\Persistence\Adapter\WordPress\WordpressOptionsContainer;
use FlexibleCouponsVendor\WPDesk\Persistence\PersistentContainer;
use FlexibleCouponsVendor\WPDesk\ShowDecision\ShouldShowStrategy;


/**
 * Two weeks notice defined in issue #90.
 *
 * @package WPDesk\ShopMagic\Admin\RateNotice
 */
class TwoWeeksNotice {

	const NOTICE_NAME                     = 'flexible_coupons_two_week_rate_notice';
	const CLOSE_TEMPORARY_NOTICE          = 'close-temporary-notice-date';
	const PLUGIN_ACTIVATION_DATE_OPTION   = 'plugin_activation_flexible-coupons/flexible-coupons.php';
	const PERSISTENT_KEY_NEVER_SHOW_AGAIN = '_two-weeks-permanent';
	const PERSISTENT_KEY_LAST_TIME_HIDDEN = '_two-weeks-last-date';

	/** @var string */
	private $assets_url;

	/** @var PersistentContainer */
	private $persistence;

	/**
	 * Current time.
	 *
	 * @var int
	 */
	private $now;

	/** @var bool */
	private $show_strategy = true;

	/**
	 * @param string $assets_url Assets URL.
	 * @param int|null $now Current time in unix.
	 */
	public function __construct(
		string $assets_url,
		$now = null
	) {
		$this->assets_url = $assets_url;
		if ( null === $now ) {
			$this->now = time();
		} else {
			$this->now = $now;
		}

		$this->persistence = new WordpressOptionsContainer( 'flexible_coupons-notice' );
	}

	/**
	 * Fire hooks.
	 */
	public function hooks() {
		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_script( 'flexible_coupons-rate-notice', $this->assets_url . '/js/two-weeks-notice.js', [ 'jquery' ], '1.2.0', true );
			}
		);
		add_action(
			'wp_ajax_flexible_coupon_close_temporary',
			function () {
				$source = isset( $_REQUEST['source'] ) ? \sanitize_text_field( \wp_unslash( $_REQUEST['source'] ) ) : '';
				if ( $source === 'already-did' ) {
					$this->persistence->set( self::PERSISTENT_KEY_NEVER_SHOW_AGAIN, true );
				} else {
					$this->persistence->set( self::PERSISTENT_KEY_LAST_TIME_HIDDEN, time() );
				}
			}
		);
	}

	/**
	 * Action links
	 *
	 * @return string[]
	 */
	private function action_links() {
		$actions[] = sprintf(
		// translators: %1$s url start tag, %2$s - url end tag.
			__( '%1$sSure, it\'s worth it!%2$s', 'flexible-coupons' ),
			'<a target="_blank" href="' . esc_url( 'https://wpde.sk/flexible-coupons-review' ) . '">',
			'</a>'
		);
		$actions[] = sprintf(
		// translators: %1$s url start tag, %2$s - url end tag.
			__( '%1$sNope, maybe later%2$s', 'flexible-coupons' ),
			'<a data-type="date" class="sm-close-temporary-notice" data-source="' . self::CLOSE_TEMPORARY_NOTICE . '" href="#">',
			'</a>'
		);
		$actions[] = sprintf(
		// translators: %1$s url start tag, %2$s - url end tag.
			__( '%1$sNo, never!%2$s', 'flexible-coupons' ),
			'<a class="sm-close-temporary-notice" data-source="already-did" href="#">',
			'</a>'
		);

		return $actions;
	}

	/**
	 * Should show message
	 *
	 * @return bool
	 */
	public function should_show_message() {
		if ( time() > strtotime( '2020-04-01' ) ) {
			if ( $this->persistence->has( self::PERSISTENT_KEY_NEVER_SHOW_AGAIN ) ) {
				return false;
			}

			if ( $this->show_strategy ) {

				/** @var string $activation_date */
				$activation_date = get_option( self::PLUGIN_ACTIVATION_DATE_OPTION );
				$two_weeks       = 60 * 60 * 24 * 7 * 2;

				if ( ! empty( $activation_date ) && strtotime( $activation_date ) + $two_weeks < $this->now ) {

					if ( $this->persistence->has( self::PERSISTENT_KEY_LAST_TIME_HIDDEN ) ) {
						$last_close = (int) $this->persistence->get( self::PERSISTENT_KEY_LAST_TIME_HIDDEN );

						return ! empty( $last_close ) && $last_close + $two_weeks < $this->now;
					}

					return true;

				}
			}
		}

		return false;
	}

	/**
	 * Show admin notice
	 *
	 * @return void
	 */
	public function show_message() {
		new PermanentDismissibleNotice(
			$this->get_message(),
			self::NOTICE_NAME,
			Notice::NOTICE_TYPE_INFO,
			10,
			[
				'class' => self::NOTICE_NAME,
				'id'    => self::NOTICE_NAME,
			]
		);
	}

	/**
	 * Get rate message
	 *
	 * @return string
	 */
	private function get_message() {
		$message  = __(
			'Amazing! You\'ve been using Flexible PDF Coupons for Woocommerce for two weeks. I hope it meets your expectations! If so, may I ask you for a big favor and a 5-star rating on the plugin\'s site?',
			'flexible-coupons'
		);
		$message .= '<br/>';
		$message .= implode( ' | ', $this->action_links() );

		return $message;
	}
}
