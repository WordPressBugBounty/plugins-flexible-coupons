<?php

namespace FlexibleCouponsVendor\Mpdf\File;

interface LocalContentLoaderInterface
{
    /**
     * @return string|null
     */
    public function load($path);
}
