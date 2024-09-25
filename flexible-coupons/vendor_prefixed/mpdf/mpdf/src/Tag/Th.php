<?php

namespace FlexibleCouponsVendor\Mpdf\Tag;

class Th extends \FlexibleCouponsVendor\Mpdf\Tag\Td
{
    public function close(&$ahtml, &$ihtml)
    {
        $this->mpdf->SetStyle('B', \false);
        parent::close($ahtml, $ihtml);
    }
}
