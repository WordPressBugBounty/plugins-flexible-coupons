<?php

namespace FlexibleCouponsVendor\WPDesk\Composer\Codeception\Commands;

use FlexibleCouponsVendor\Composer\Command\BaseCommand as CodeceptionBaseCommand;
use FlexibleCouponsVendor\Symfony\Component\Console\Output\OutputInterface;
/**
 * Base for commands - declares common methods.
 *
 * @package WPDesk\Composer\Codeception\Commands
 */
abstract class BaseCommand extends \FlexibleCouponsVendor\Composer\Command\BaseCommand
{
    /**
     * @param string $command
     * @param OutputInterface $output
     */
    protected function execAndOutput($command, \FlexibleCouponsVendor\Symfony\Component\Console\Output\OutputInterface $output)
    {
        \passthru($command);
    }
}
