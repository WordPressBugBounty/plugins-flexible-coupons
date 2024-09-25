<?php

namespace FlexibleCouponsVendor\Mpdf\Tag;

class Bookmark extends \FlexibleCouponsVendor\Mpdf\Tag\Tag
{
    public function open($attr, &$ahtml, &$ihtml)
    {
        if (isset($attr['CONTENT'])) {
            $objattr = [];
            $objattr['CONTENT'] = \htmlspecialchars_decode($attr['CONTENT'], \ENT_QUOTES);
            $objattr['type'] = 'bookmark';
            if (!empty($attr['LEVEL'])) {
                $objattr['bklevel'] = $attr['LEVEL'];
            } else {
                $objattr['bklevel'] = 0;
            }
            $e = "\xbb\xa4\xactype=bookmark,objattr=" . \serialize($objattr) . "\xbb\xa4\xac";
            if ($this->mpdf->tableLevel) {
                $this->mpdf->cell[$this->mpdf->row][$this->mpdf->col]['textbuffer'][] = [$e];
            } else {
                // *TABLES*
                $this->mpdf->textbuffer[] = [$e];
            }
            // *TABLES*
        }
    }
    public function close(&$ahtml, &$ihtml)
    {
    }
}
