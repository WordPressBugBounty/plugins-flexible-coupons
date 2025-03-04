<?php

namespace FlexibleCouponsVendor\WPDesk\Persistence;

use FlexibleCouponsVendor\Psr\Container\NotFoundExceptionInterface;
/**
 * @package WPDesk\Persistence
 */
class ElementNotExistsException extends \RuntimeException implements NotFoundExceptionInterface
{
}
