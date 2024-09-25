<?php

namespace FlexibleCouponsVendor\WPDesk\Codeception\Command;

use FlexibleCouponsVendor\Codeception\Lib\Generator\Test;
/**
 * Class code for codeception example test for WP Desk plugin activation.
 *
 * @package WPDesk\Codeception\Command
 */
class WooCommerceTestGenerator extends \FlexibleCouponsVendor\Codeception\Lib\Generator\Test
{
    protected $template = <<<EOF
<?php {{namespace}}

use WPDesk\\Codeception\\Tests\\Acceptance\\Cest\\AbstractCestForWooCommerce;

/**
 * Common WooCommerce tests.
 */
class {{name}} extends AbstractCestForWooCommerce {

}
EOF;
}
