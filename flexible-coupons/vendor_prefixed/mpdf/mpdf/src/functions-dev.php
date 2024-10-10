<?php

namespace FlexibleCouponsVendor;

if (!\function_exists('FlexibleCouponsVendor\dd')) {
    function dd(...$args)
    {
        if (\function_exists('FlexibleCouponsVendor\dump')) {
            dump(...$args);
        } else {
            \var_dump(...$args);
        }
        die;
    }
}
