<?php

namespace FlexibleCouponsVendor\WPDesk\Composer\Codeception;

use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests;
use FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \FlexibleCouponsVendor\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage(), new \FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests()];
    }
}
