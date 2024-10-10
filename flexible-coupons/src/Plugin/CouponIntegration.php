<?php
/**
 * Integration. Main class.
 *
 * @package WPDesk\FlexibleCoupons
 */

namespace WPDesk\FlexibleCoupons;

use FlexibleCouponsVendor\WPDesk\Library\CouponInterfaces\EditorIntegration;
use FlexibleCouponsVendor\WPDesk\Library\WPCoupons\CouponsIntegration;
/**
 * This class extends coupons library. Library is a free version of coupons.
 *
 * @package WPDesk\FlexibleCoupons
 */
class CouponIntegration extends CouponsIntegration {

	/**
	 * @param EditorIntegration $editor Editor integration.
	 * @param string            $plugin_version
	 */
	public function __construct( EditorIntegration $editor, string $plugin_version ) {
		parent::__construct( $editor, $plugin_version );
		$this->set_product_fields( new ProductFieldsDefinition() );
	}

	public function hooks() {
		parent::hooks();
		$this->hooks_on_hookable_objects();
	}

}
