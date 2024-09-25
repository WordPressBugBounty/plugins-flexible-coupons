<?php

namespace FlexibleCouponsVendor\WPDesk\Library\Marketing\RatePlugin;

use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FlexibleCouponsVendor\WPDesk\View\Resolver\ChainResolver;
use FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver;
/**
 * Displays a rating box for the plugin in the WordPress repository.
 */
class RateBox
{
    /** @var Renderer */
    private $renderer;
    public function __construct(?\FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer $renderer = null)
    {
        $this->renderer = $renderer ?? new \FlexibleCouponsVendor\WPDesk\View\Renderer\SimplePhpRenderer(new \FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver(__DIR__ . '/Views/'));
    }
    /**
     * @param string $url
     * @param string $description
     * @param string $header
     * @param string $footer
     *
     * @return string
     */
    public function render(string $url, string $description = '', string $header = '', string $footer = '') : string
    {
        return $this->renderer->render('rate-plugin', ['url' => $url, 'description' => $description, 'header' => $header, 'footer' => $footer]);
    }
}
