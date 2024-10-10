<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Resolver;

use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\View\Resolver\DirResolver;
use FlexibleCouponsVendor\WPDesk\View\Resolver\Resolver;
/**
 * Use with View to resolver form fields to default templates.
 *
 * @package WPDesk\Forms\Resolver
 */
class DefaultFormFieldResolver implements Resolver
{
    /** @var Resolver */
    private $dir_resolver;
    public function __construct()
    {
        $this->dir_resolver = new DirResolver(__DIR__ . '/../../templates');
    }
    public function resolve($name, Renderer $renderer = null)
    {
        return $this->dir_resolver->resolve($name, $renderer);
    }
}
