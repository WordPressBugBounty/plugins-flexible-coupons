<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Serializer;

use FlexibleCouponsVendor\WPDesk\Forms\Serializer;
class NoSerialize implements \FlexibleCouponsVendor\WPDesk\Forms\Serializer
{
    public function serialize($value)
    {
        return $value;
    }
    public function unserialize($value)
    {
        return $value;
    }
}
