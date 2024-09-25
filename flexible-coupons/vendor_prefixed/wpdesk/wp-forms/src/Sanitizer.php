<?php

namespace FlexibleCouponsVendor\WPDesk\Forms;

interface Sanitizer
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    public function sanitize($value);
}
