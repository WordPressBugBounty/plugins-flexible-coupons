<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Serializer;

use FlexibleCouponsVendor\WPDesk\Forms\Serializer;
class SerializeSerializer implements Serializer
{
    public function serialize($value)
    {
        return serialize($value);
    }
    public function unserialize($value)
    {
        return unserialize($value);
    }
}
