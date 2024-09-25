<?php

namespace FlexibleCouponsVendor\WPDesk\View\Resolver;

use FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer;
use FlexibleCouponsVendor\WPDesk\View\Resolver\Exception\CanNotResolve;
/**
 * This resolver never finds the file
 *
 * @package WPDesk\View\Resolver
 */
class NullResolver implements \FlexibleCouponsVendor\WPDesk\View\Resolver\Resolver
{
    public function resolve($name, \FlexibleCouponsVendor\WPDesk\View\Renderer\Renderer $renderer = null)
    {
        throw new \FlexibleCouponsVendor\WPDesk\View\Resolver\Exception\CanNotResolve('Null Cannot resolve');
    }
}
