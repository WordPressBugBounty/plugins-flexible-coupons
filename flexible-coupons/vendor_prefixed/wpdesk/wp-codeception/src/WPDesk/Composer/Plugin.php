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
class Plugin implements PluginInterface, Capable
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var IOInterface
     */
    private $io;
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    /**
     * @inheritDoc
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }
    public function getCapabilities()
    {
        return [\FlexibleCouponsVendor\Composer\Plugin\Capability\CommandProvider::class => CommandProvider::class];
    }
}
