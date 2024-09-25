<?php

namespace FlexibleCouponsVendor\WPDesk\Composer\Codeception;

use FlexibleCouponsVendor\Composer\Composer;
use FlexibleCouponsVendor\Composer\IO\IOInterface;
use FlexibleCouponsVendor\Composer\Plugin\Capable;
use FlexibleCouponsVendor\Composer\Plugin\PluginInterface;
/**
 * Composer plugin.
 *
 * @package WPDesk\Composer\Codeception
 */
class Plugin implements \FlexibleCouponsVendor\Composer\Plugin\PluginInterface, \FlexibleCouponsVendor\Composer\Plugin\Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(\FlexibleCouponsVendor\Composer\Composer $composer, \FlexibleCouponsVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function deactivate(\FlexibleCouponsVendor\Composer\Composer $composer, \FlexibleCouponsVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function uninstall(\FlexibleCouponsVendor\Composer\Composer $composer, \FlexibleCouponsVendor\Composer\IO\IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\FlexibleCouponsVendor\Composer\Plugin\Capability\CommandProvider::class => \FlexibleCouponsVendor\WPDesk\Composer\Codeception\CommandProvider::class];
    }
}
