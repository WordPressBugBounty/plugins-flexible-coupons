<?php

namespace FlexibleCouponsVendor\Mpdf\Tag;

class NewColumn extends \FlexibleCouponsVendor\Mpdf\Tag\Tag
{
    public function open($attr, &$ahtml, &$ihtml)
    {
        $this->mpdf->ignorefollowingspaces = \true;
        $this->mpdf->NewColumn();
        $this->mpdf->ColumnAdjust = \false;
        // disables all column height adjustment for the page.
    }
    public function close(&$ahtml, &$ihtml)
    {
    }
}
