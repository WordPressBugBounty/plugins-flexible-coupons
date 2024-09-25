<?php

namespace FlexibleCouponsVendor\WPDesk\Forms\Serializer;

use FlexibleCouponsVendor\WPDesk\Forms\Serializer;
class JsonSerializer implements \FlexibleCouponsVendor\WPDesk\Forms\Serializer
{
    public function serialize($value)
    {
        return \json_encode($value);
    }
    public function unserialize($value)
    {
        return \json_decode($value, \true);
    }
}
