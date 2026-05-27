<?php

namespace FlexibleCouponsVendor\Mpdf\File;

class LocalContentLoader implements \FlexibleCouponsVendor\Mpdf\File\LocalContentLoaderInterface
{
    public function load($path)
    {
        return file_get_contents($path);
    }
}
