<?php
/**
 * Integration. Main class.
 *
 * @package WPDesk\FlexibleCoupons
 */

namespace WPDesk\FlexibleCoupons;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\EditorIntegration;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\CouponsIntegration;
use FlexibleCouponsVendor\Psr\Log\LoggerInterface;

/**
 * This class extends coupons library. Library is a free version of coupons.
 *
 * @package WPDesk\FlexibleCoupons
 */
class CouponIntegration extends CouponsIntegration {

	public function __construct(
		EditorIntegration $editor,
		string $plugin_version,
		LoggerInterface $logger,
		string $text_domain,
		string $languages_path
	) {
		parent::__construct(
			$editor,
			$plugin_version,
			$logger,
			$text_domain,
			$languages_path
		);
		$this->set_product_fields( new ProductFieldsDefinition() );
	}

	public function hooks() {
		parent::hooks();
		$this->hooks_on_hookable_objects();
	}
}
