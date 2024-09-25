<?php

namespace FlexibleCouponsVendor\Mpdf\Tag;

use FlexibleCouponsVendor\Mpdf\Strict;
use FlexibleCouponsVendor\Mpdf\Cache;
use FlexibleCouponsVendor\Mpdf\Color\ColorConverter;
use FlexibleCouponsVendor\Mpdf\CssManager;
use FlexibleCouponsVendor\Mpdf\Form;
use FlexibleCouponsVendor\Mpdf\Image\ImageProcessor;
use FlexibleCouponsVendor\Mpdf\Language\LanguageToFontInterface;
use FlexibleCouponsVendor\Mpdf\Mpdf;
use FlexibleCouponsVendor\Mpdf\Otl;
use FlexibleCouponsVendor\Mpdf\SizeConverter;
use FlexibleCouponsVendor\Mpdf\TableOfContents;
abstract class Tag
{
    use Strict;
    /**
     * @var \Mpdf\Mpdf
     */
    protected $mpdf;
    /**
     * @var \Mpdf\Cache
     */
    protected $cache;
    /**
     * @var \Mpdf\CssManager
     */
    protected $cssManager;
    /**
     * @var \Mpdf\Form
     */
    protected $form;
    /**
     * @var \Mpdf\Otl
     */
    protected $otl;
    /**
     * @var \Mpdf\TableOfContents
     */
    protected $tableOfContents;
    /**
     * @var \Mpdf\SizeConverter
     */
    protected $sizeConverter;
    /**
     * @var \Mpdf\Color\ColorConverter
     */
    protected $colorConverter;
    /**
     * @var \Mpdf\Image\ImageProcessor
     */
    protected $imageProcessor;
    /**
     * @var \Mpdf\Language\LanguageToFontInterface
     */
    protected $languageToFont;
    const ALIGN = ['left' => 'L', 'center' => 'C', 'right' => 'R', 'top' => 'T', 'text-top' => 'TT', 'middle' => 'M', 'baseline' => 'BS', 'bottom' => 'B', 'text-bottom' => 'TB', 'justify' => 'J'];
    public function __construct(\FlexibleCouponsVendor\Mpdf\Mpdf $mpdf, \FlexibleCouponsVendor\Mpdf\Cache $cache, \FlexibleCouponsVendor\Mpdf\CssManager $cssManager, \FlexibleCouponsVendor\Mpdf\Form $form, \FlexibleCouponsVendor\Mpdf\Otl $otl, \FlexibleCouponsVendor\Mpdf\TableOfContents $tableOfContents, \FlexibleCouponsVendor\Mpdf\SizeConverter $sizeConverter, \FlexibleCouponsVendor\Mpdf\Color\ColorConverter $colorConverter, \FlexibleCouponsVendor\Mpdf\Image\ImageProcessor $imageProcessor, \FlexibleCouponsVendor\Mpdf\Language\LanguageToFontInterface $languageToFont)
    {
        $this->mpdf = $mpdf;
        $this->cache = $cache;
        $this->cssManager = $cssManager;
        $this->form = $form;
        $this->otl = $otl;
        $this->tableOfContents = $tableOfContents;
        $this->sizeConverter = $sizeConverter;
        $this->colorConverter = $colorConverter;
        $this->imageProcessor = $imageProcessor;
        $this->languageToFont = $languageToFont;
    }
    public function getTagName()
    {
        $tag = \get_class($this);
        return \strtoupper(\str_replace('FlexibleCouponsVendor\Mpdf\Tag\\', '', $tag));
    }
    protected function getAlign($property)
    {
        $property = \strtolower($property);
        return \array_key_exists($property, self::ALIGN) ? self::ALIGN[$property] : '';
    }
    public abstract function open($attr, &$ahtml, &$ihtml);
    public abstract function close(&$ahtml, &$ihtml);
}
