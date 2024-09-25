<?php

namespace FlexibleCouponsVendor\Mpdf;

use FlexibleCouponsVendor\Mpdf\Color\ColorConverter;
use FlexibleCouponsVendor\Mpdf\Color\ColorModeConverter;
use FlexibleCouponsVendor\Mpdf\Color\ColorSpaceRestrictor;
use FlexibleCouponsVendor\Mpdf\Fonts\FontCache;
use FlexibleCouponsVendor\Mpdf\Fonts\FontFileFinder;
use FlexibleCouponsVendor\Mpdf\Image\ImageProcessor;
use FlexibleCouponsVendor\Mpdf\Pdf\Protection;
use FlexibleCouponsVendor\Mpdf\Pdf\Protection\UniqidGenerator;
use FlexibleCouponsVendor\Mpdf\Writer\BaseWriter;
use FlexibleCouponsVendor\Mpdf\Writer\BackgroundWriter;
use FlexibleCouponsVendor\Mpdf\Writer\ColorWriter;
use FlexibleCouponsVendor\Mpdf\Writer\BookmarkWriter;
use FlexibleCouponsVendor\Mpdf\Writer\FontWriter;
use FlexibleCouponsVendor\Mpdf\Writer\FormWriter;
use FlexibleCouponsVendor\Mpdf\Writer\ImageWriter;
use FlexibleCouponsVendor\Mpdf\Writer\JavaScriptWriter;
use FlexibleCouponsVendor\Mpdf\Writer\MetadataWriter;
use FlexibleCouponsVendor\Mpdf\Writer\OptionalContentWriter;
use FlexibleCouponsVendor\Mpdf\Writer\PageWriter;
use FlexibleCouponsVendor\Mpdf\Writer\ResourceWriter;
use Psr\Log\LoggerInterface;
class ServiceFactory
{
    public function getServices(\FlexibleCouponsVendor\Mpdf\Mpdf $mpdf, \Psr\Log\LoggerInterface $logger, $config, $restrictColorSpace, $languageToFont, $scriptToLanguage, $fontDescriptor, $bmp, $directWrite, $wmf)
    {
        $sizeConverter = new \FlexibleCouponsVendor\Mpdf\SizeConverter($mpdf->dpi, $mpdf->default_font_size, $mpdf, $logger);
        $colorModeConverter = new \FlexibleCouponsVendor\Mpdf\Color\ColorModeConverter();
        $colorSpaceRestrictor = new \FlexibleCouponsVendor\Mpdf\Color\ColorSpaceRestrictor($mpdf, $colorModeConverter, $restrictColorSpace);
        $colorConverter = new \FlexibleCouponsVendor\Mpdf\Color\ColorConverter($mpdf, $colorModeConverter, $colorSpaceRestrictor);
        $tableOfContents = new \FlexibleCouponsVendor\Mpdf\TableOfContents($mpdf, $sizeConverter);
        $cacheBasePath = $config['tempDir'] . '/mpdf';
        $cache = new \FlexibleCouponsVendor\Mpdf\Cache($cacheBasePath, $config['cacheCleanupInterval']);
        $fontCache = new \FlexibleCouponsVendor\Mpdf\Fonts\FontCache(new \FlexibleCouponsVendor\Mpdf\Cache($cacheBasePath . '/ttfontdata', $config['cacheCleanupInterval']));
        $fontFileFinder = new \FlexibleCouponsVendor\Mpdf\Fonts\FontFileFinder($config['fontDir']);
        $cssManager = new \FlexibleCouponsVendor\Mpdf\CssManager($mpdf, $cache, $sizeConverter, $colorConverter);
        $otl = new \FlexibleCouponsVendor\Mpdf\Otl($mpdf, $fontCache);
        $protection = new \FlexibleCouponsVendor\Mpdf\Pdf\Protection(new \FlexibleCouponsVendor\Mpdf\Pdf\Protection\UniqidGenerator());
        $writer = new \FlexibleCouponsVendor\Mpdf\Writer\BaseWriter($mpdf, $protection);
        $gradient = new \FlexibleCouponsVendor\Mpdf\Gradient($mpdf, $sizeConverter, $colorConverter, $writer);
        $formWriter = new \FlexibleCouponsVendor\Mpdf\Writer\FormWriter($mpdf, $writer);
        $form = new \FlexibleCouponsVendor\Mpdf\Form($mpdf, $otl, $colorConverter, $writer, $formWriter);
        $hyphenator = new \FlexibleCouponsVendor\Mpdf\Hyphenator($mpdf);
        $remoteContentFetcher = new \FlexibleCouponsVendor\Mpdf\RemoteContentFetcher($mpdf, $logger);
        $imageProcessor = new \FlexibleCouponsVendor\Mpdf\Image\ImageProcessor($mpdf, $otl, $cssManager, $sizeConverter, $colorConverter, $colorModeConverter, $cache, $languageToFont, $scriptToLanguage, $remoteContentFetcher, $logger);
        $tag = new \FlexibleCouponsVendor\Mpdf\Tag($mpdf, $cache, $cssManager, $form, $otl, $tableOfContents, $sizeConverter, $colorConverter, $imageProcessor, $languageToFont);
        $fontWriter = new \FlexibleCouponsVendor\Mpdf\Writer\FontWriter($mpdf, $writer, $fontCache, $fontDescriptor);
        $metadataWriter = new \FlexibleCouponsVendor\Mpdf\Writer\MetadataWriter($mpdf, $writer, $form, $protection, $logger);
        $imageWriter = new \FlexibleCouponsVendor\Mpdf\Writer\ImageWriter($mpdf, $writer);
        $pageWriter = new \FlexibleCouponsVendor\Mpdf\Writer\PageWriter($mpdf, $form, $writer, $metadataWriter);
        $bookmarkWriter = new \FlexibleCouponsVendor\Mpdf\Writer\BookmarkWriter($mpdf, $writer);
        $optionalContentWriter = new \FlexibleCouponsVendor\Mpdf\Writer\OptionalContentWriter($mpdf, $writer);
        $colorWriter = new \FlexibleCouponsVendor\Mpdf\Writer\ColorWriter($mpdf, $writer);
        $backgroundWriter = new \FlexibleCouponsVendor\Mpdf\Writer\BackgroundWriter($mpdf, $writer);
        $javaScriptWriter = new \FlexibleCouponsVendor\Mpdf\Writer\JavaScriptWriter($mpdf, $writer);
        $resourceWriter = new \FlexibleCouponsVendor\Mpdf\Writer\ResourceWriter($mpdf, $writer, $colorWriter, $fontWriter, $imageWriter, $formWriter, $optionalContentWriter, $backgroundWriter, $bookmarkWriter, $metadataWriter, $javaScriptWriter, $logger);
        return ['otl' => $otl, 'bmp' => $bmp, 'cache' => $cache, 'cssManager' => $cssManager, 'directWrite' => $directWrite, 'fontCache' => $fontCache, 'fontFileFinder' => $fontFileFinder, 'form' => $form, 'gradient' => $gradient, 'tableOfContents' => $tableOfContents, 'tag' => $tag, 'wmf' => $wmf, 'sizeConverter' => $sizeConverter, 'colorConverter' => $colorConverter, 'hyphenator' => $hyphenator, 'remoteContentFetcher' => $remoteContentFetcher, 'imageProcessor' => $imageProcessor, 'protection' => $protection, 'languageToFont' => $languageToFont, 'scriptToLanguage' => $scriptToLanguage, 'writer' => $writer, 'fontWriter' => $fontWriter, 'metadataWriter' => $metadataWriter, 'imageWriter' => $imageWriter, 'formWriter' => $formWriter, 'pageWriter' => $pageWriter, 'bookmarkWriter' => $bookmarkWriter, 'optionalContentWriter' => $optionalContentWriter, 'colorWriter' => $colorWriter, 'backgroundWriter' => $backgroundWriter, 'javaScriptWriter' => $javaScriptWriter, 'resourceWriter' => $resourceWriter];
    }
}
