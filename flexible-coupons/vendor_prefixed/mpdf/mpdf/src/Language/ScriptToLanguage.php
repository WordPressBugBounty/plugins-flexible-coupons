<?php

namespace FlexibleCouponsVendor\Mpdf\Language;

use FlexibleCouponsVendor\Mpdf\Ucdn;
class ScriptToLanguage implements \FlexibleCouponsVendor\Mpdf\Language\ScriptToLanguageInterface
{
    private $scriptDelimiterMap = [
        'viet' => "\\x{01A0}\\x{01A1}\\x{01AF}\\x{01B0}\\x{1EA0}-\\x{1EF1}",
        'persian' => "\\x{067E}\\x{0686}\\x{0698}\\x{06AF}",
        'urdu' => "\\x{0679}\\x{0688}\\x{0691}\\x{06BA}\\x{06BE}\\x{06C1}\\x{06D2}",
        'pashto' => "\\x{067C}\\x{0681}\\x{0685}\\x{0689}\\x{0693}\\x{0696}\\x{069A}\\x{06BC}\\x{06D0}",
        // ? and U+06AB, U+06CD
        'sindhi' => "\\x{067A}\\x{067B}\\x{067D}\\x{067F}\\x{0680}\\x{0684}\\x{068D}\\x{068A}\\x{068F}\\x{068C}\\x{0687}\\x{0683}\\x{0699}\\x{06AA}\\x{06A6}\\x{06BB}\\x{06B1}\\x{06B3}",
    ];
    private $scriptToLanguageMap = [
        /* European */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LATIN => 'und-Latn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_ARMENIAN => 'hy',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CYRILLIC => 'und-Cyrl',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GEORGIAN => 'ka',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GREEK => 'el',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_COPTIC => 'cop',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GOTHIC => 'got',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CYPRIOT => 'und-Cprt',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GLAGOLITIC => 'und-Glag',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LINEAR_B => 'und-Linb',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OGHAM => 'und-Ogam',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OLD_ITALIC => 'und-Ital',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_RUNIC => 'und-Runr',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SHAVIAN => 'und-Shaw',
        /* African */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_ETHIOPIC => 'und-Ethi',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_NKO => 'nqo',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BAMUM => 'bax',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_VAI => 'vai',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_EGYPTIAN_HIEROGLYPHS => 'und-Egyp',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MEROITIC_CURSIVE => 'und-Merc',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MEROITIC_HIEROGLYPHS => 'und-Mero',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OSMANYA => 'und-Osma',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TIFINAGH => 'und-Tfng',
        /* Middle Eastern */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_ARABIC => 'und-Arab',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_HEBREW => 'he',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SYRIAC => 'syr',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_IMPERIAL_ARAMAIC => 'arc',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_AVESTAN => 'ae',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CARIAN => 'xcr',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LYCIAN => 'xlc',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LYDIAN => 'xld',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MANDAIC => 'mid',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OLD_PERSIAN => 'peo',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_PHOENICIAN => 'phn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SAMARITAN => 'smp',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_UGARITIC => 'uga',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CUNEIFORM => 'und-Xsux',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OLD_SOUTH_ARABIAN => 'und-Sarb',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_INSCRIPTIONAL_PARTHIAN => 'und-Prti',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_INSCRIPTIONAL_PAHLAVI => 'und-Phli',
        /* Central Asian */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MONGOLIAN => 'mn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TIBETAN => 'bo',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OLD_TURKIC => 'und-Orkh',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_PHAGS_PA => 'und-Phag',
        /* South Asian */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BENGALI => 'bn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_DEVANAGARI => 'hi',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GUJARATI => 'gu',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_GURMUKHI => 'pa',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KANNADA => 'kn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MALAYALAM => 'ml',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_ORIYA => 'or',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SINHALA => 'si',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAMIL => 'ta',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TELUGU => 'te',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CHAKMA => 'ccp',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LEPCHA => 'lep',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LIMBU => 'lif',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_OL_CHIKI => 'sat',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SAURASHTRA => 'saz',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SYLOTI_NAGRI => 'syl',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAKRI => 'dgo',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_THAANA => 'dv',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BRAHMI => 'und-Brah',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KAITHI => 'und-Kthi',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KHAROSHTHI => 'und-Khar',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MEETEI_MAYEK => 'und-Mtei',
        /* or omp-Mtei */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SHARADA => 'und-Shrd',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SORA_SOMPENG => 'und-Sora',
        /* South East Asian */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KHMER => 'km',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LAO => 'lo',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MYANMAR => 'my',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_THAI => 'th',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BALINESE => 'ban',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BATAK => 'bya',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BUGINESE => 'bug',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CHAM => 'cjm',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_JAVANESE => 'jv',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KAYAH_LI => 'und-Kali',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_REJANG => 'und-Rjng',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_SUNDANESE => 'su',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAI_LE => 'tdd',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAI_THAM => 'und-Lana',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAI_VIET => 'blt',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_NEW_TAI_LUE => 'und-Talu',
        /* Phillipine */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BUHID => 'bku',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_HANUNOO => 'hnn',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAGALOG => 'tl',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_TAGBANWA => 'tbw',
        /* East Asian */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_HAN => 'und-Hans',
        // und-Hans (simplified) or und-Hant (Traditional)
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_HANGUL => 'ko',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_HIRAGANA => 'ja',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_KATAKANA => 'ja',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_LISU => 'lis',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BOPOMOFO => 'und-Bopo',
        // zh-CN, zh-TW, zh-HK
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_MIAO => 'und-Plrd',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_YI => 'und-Yiii',
        /* American */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CHEROKEE => 'chr',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_CANADIAN_ABORIGINAL => 'cr',
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_DESERET => 'und-Dsrt',
        /* Other */
        \FlexibleCouponsVendor\Mpdf\Ucdn::SCRIPT_BRAILLE => 'und-Brai',
    ];
    public function getLanguageByScript($script)
    {
        return isset($this->scriptToLanguageMap[$script]) ? $this->scriptToLanguageMap[$script] : null;
    }
    public function getLanguageDelimiters($language)
    {
        return isset($this->scriptDelimiterMap[$language]) ? $this->scriptDelimiterMap[$language] : null;
    }
}
