<?php

declare (strict_types=1);
namespace FlexibleCouponsVendor\WPDesk\Codeception\Composer;

use FlexibleCouponsVendor\Composer\Composer;
use FlexibleCouponsVendor\Composer\IO\IOInterface;
use FlexibleCouponsVendor\Composer\Plugin\Capable;
use FlexibleCouponsVendor\Composer\Plugin\PluginInterface;
final class Plugin implements PluginInterface, Capable
{
    public function activate(Composer $composer, IOInterface $io)
    {
    }
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
    /**
     * @return array<class-string, class-string>
     */
    public function getCapabilities()
    {
        return [\FlexibleCouponsVendor\Composer\Plugin\Capability\CommandProvider::class => CommandProvider::class];
    }
}
