<?php

// phpcs:disable WordPress.PHP.DiscouragedPHPFunctions
namespace FlexibleCouponsVendor\WPDesk\Forms\Serializer;

use FlexibleCouponsVendor\WPDesk\Forms\Serializer;
class SerializeSerializer implements Serializer
{
    public function serialize($value): string
    {
        return serialize($value);
    }
    public function unserialize(string $value)
    {
        return unserialize($value);
    }
}
