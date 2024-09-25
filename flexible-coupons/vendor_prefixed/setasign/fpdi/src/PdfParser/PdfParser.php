<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2023 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */
namespace FlexibleCouponsVendor\setasign\Fpdi\PdfParser;

use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\CrossReference\CrossReference;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfArray;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfBoolean;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfDictionary;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfHexString;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObject;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObjectReference;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfName;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNull;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNumeric;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfStream;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfString;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfToken;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfType;
use FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException;
/**
 * A PDF parser class
 */
class PdfParser
{
    /**
     * @var StreamReader
     */
    protected $streamReader;
    /**
     * @var Tokenizer
     */
    protected $tokenizer;
    /**
     * The file header.
     *
     * @var string
     */
    protected $fileHeader;
    /**
     * The offset to the file header.
     *
     * @var int
     */
    protected $fileHeaderOffset;
    /**
     * @var CrossReference|null
     */
    protected $xref;
    /**
     * All read objects.
     *
     * @var array
     */
    protected $objects = [];
    /**
     * PdfParser constructor.
     *
     * @param StreamReader $streamReader
     */
    public function __construct(\FlexibleCouponsVendor\setasign\Fpdi\PdfParser\StreamReader $streamReader)
    {
        $this->streamReader = $streamReader;
        $this->tokenizer = new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Tokenizer($streamReader);
    }
    /**
     * Removes cycled references.
     *
     * @internal
     */
    public function cleanUp()
    {
        $this->xref = null;
    }
    /**
     * Get the stream reader instance.
     *
     * @return StreamReader
     */
    public function getStreamReader()
    {
        return $this->streamReader;
    }
    /**
     * Get the tokenizer instance.
     *
     * @return Tokenizer
     */
    public function getTokenizer()
    {
        return $this->tokenizer;
    }
    /**
     * Resolves the file header.
     *
     * @throws PdfParserException
     * @return int
     */
    protected function resolveFileHeader()
    {
        if ($this->fileHeader) {
            return $this->fileHeaderOffset;
        }
        $this->streamReader->reset(0);
        $maxIterations = 1000;
        while (\true) {
            $buffer = $this->streamReader->getBuffer(\false);
            $offset = \strpos($buffer, '%PDF-');
            if ($offset === \false) {
                if (!$this->streamReader->increaseLength(100) || --$maxIterations === 0) {
                    throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\PdfParserException('Unable to find PDF file header.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\PdfParserException::FILE_HEADER_NOT_FOUND);
                }
                continue;
            }
            break;
        }
        $this->fileHeaderOffset = $offset;
        $this->streamReader->setOffset($offset);
        $this->fileHeader = \trim($this->streamReader->readLine());
        return $this->fileHeaderOffset;
    }
    /**
     * Get the cross-reference instance.
     *
     * @return CrossReference
     * @throws CrossReferenceException
     * @throws PdfParserException
     */
    public function getCrossReference()
    {
        if ($this->xref === null) {
            $this->xref = new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\CrossReference\CrossReference($this, $this->resolveFileHeader());
        }
        return $this->xref;
    }
    /**
     * Get the PDF version.
     *
     * @return int[] An array of major and minor version.
     * @throws PdfParserException
     */
    public function getPdfVersion()
    {
        $this->resolveFileHeader();
        if (\preg_match('/%PDF-(\\d)\\.(\\d)/', $this->fileHeader, $result) === 0) {
            throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\PdfParserException('Unable to extract PDF version from file header.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\PdfParserException::PDF_VERSION_NOT_FOUND);
        }
        list(, $major, $minor) = $result;
        $catalog = $this->getCatalog();
        if (isset($catalog->value['Version'])) {
            $versionParts = \explode('.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfName::unescape(\FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfType::resolve($catalog->value['Version'], $this)->value));
            if (\count($versionParts) === 2) {
                list($major, $minor) = $versionParts;
            }
        }
        return [(int) $major, (int) $minor];
    }
    /**
     * Get the catalog dictionary.
     *
     * @return PdfDictionary
     * @throws Type\PdfTypeException
     * @throws CrossReferenceException
     * @throws PdfParserException
     */
    public function getCatalog()
    {
        $trailer = $this->getCrossReference()->getTrailer();
        $catalog = \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfType::resolve(\FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfDictionary::get($trailer, 'Root'), $this);
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfDictionary::ensure($catalog);
    }
    /**
     * Get an indirect object by its object number.
     *
     * @param int $objectNumber
     * @param bool $cache
     * @return PdfIndirectObject
     * @throws CrossReferenceException
     * @throws PdfParserException
     */
    public function getIndirectObject($objectNumber, $cache = \false)
    {
        $objectNumber = (int) $objectNumber;
        if (isset($this->objects[$objectNumber])) {
            return $this->objects[$objectNumber];
        }
        $object = $this->getCrossReference()->getIndirectObject($objectNumber);
        if ($cache) {
            $this->objects[$objectNumber] = $object;
        }
        return $object;
    }
    /**
     * Read a PDF value.
     *
     * @param null|bool|string $token
     * @param null|string $expectedType
     * @return false|PdfArray|PdfBoolean|PdfDictionary|PdfHexString|PdfIndirectObject|PdfIndirectObjectReference|PdfName|PdfNull|PdfNumeric|PdfStream|PdfString|PdfToken
     * @throws Type\PdfTypeException
     */
    public function readValue($token = null, $expectedType = null)
    {
        if ($token === null) {
            $token = $this->tokenizer->getNextToken();
        }
        if ($token === \false) {
            if ($expectedType !== null) {
                throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
            }
            return \false;
        }
        switch ($token) {
            case '(':
                $this->ensureExpectedType($token, $expectedType);
                return $this->parsePdfString();
            case '<':
                if ($this->streamReader->getByte() === '<') {
                    $this->ensureExpectedType('<<', $expectedType);
                    $this->streamReader->addOffset(1);
                    return $this->parsePdfDictionary();
                }
                $this->ensureExpectedType($token, $expectedType);
                return $this->parsePdfHexString();
            case '/':
                $this->ensureExpectedType($token, $expectedType);
                return $this->parsePdfName();
            case '[':
                $this->ensureExpectedType($token, $expectedType);
                return $this->parsePdfArray();
            default:
                if (\is_numeric($token)) {
                    if (($token2 = $this->tokenizer->getNextToken()) !== \false) {
                        if (\is_numeric($token2) && ($token3 = $this->tokenizer->getNextToken()) !== \false) {
                            switch ($token3) {
                                case 'obj':
                                    if ($expectedType !== null && $expectedType !== \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObject::class) {
                                        throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
                                    }
                                    return $this->parsePdfIndirectObject((int) $token, (int) $token2);
                                case 'R':
                                    if ($expectedType !== null && $expectedType !== \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObjectReference::class) {
                                        throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
                                    }
                                    return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObjectReference::create((int) $token, (int) $token2);
                            }
                            $this->tokenizer->pushStack($token3);
                        }
                        $this->tokenizer->pushStack($token2);
                    }
                    if ($expectedType !== null && $expectedType !== \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNumeric::class) {
                        throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
                    }
                    return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNumeric::create($token + 0);
                }
                if ($token === 'true' || $token === 'false') {
                    $this->ensureExpectedType($token, $expectedType);
                    return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfBoolean::create($token === 'true');
                }
                if ($token === 'null') {
                    $this->ensureExpectedType($token, $expectedType);
                    return new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNull();
                }
                if ($expectedType !== null && $expectedType !== \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfToken::class) {
                    throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
                }
                $v = new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfToken();
                $v->value = $token;
                return $v;
        }
    }
    /**
     * @return PdfString
     */
    protected function parsePdfString()
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfString::parse($this->streamReader);
    }
    /**
     * @return false|PdfHexString
     */
    protected function parsePdfHexString()
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfHexString::parse($this->streamReader);
    }
    /**
     * @return bool|PdfDictionary
     * @throws PdfTypeException
     */
    protected function parsePdfDictionary()
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfDictionary::parse($this->tokenizer, $this->streamReader, $this);
    }
    /**
     * @return PdfName
     */
    protected function parsePdfName()
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfName::parse($this->tokenizer, $this->streamReader);
    }
    /**
     * @return false|PdfArray
     * @throws PdfTypeException
     */
    protected function parsePdfArray()
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfArray::parse($this->tokenizer, $this);
    }
    /**
     * @param int $objectNumber
     * @param int $generationNumber
     * @return false|PdfIndirectObject
     * @throws Type\PdfTypeException
     */
    protected function parsePdfIndirectObject($objectNumber, $generationNumber)
    {
        return \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfIndirectObject::parse($objectNumber, $generationNumber, $this, $this->tokenizer, $this->streamReader);
    }
    /**
     * Ensures that the token will evaluate to an expected object type (or not).
     *
     * @param string $token
     * @param string|null $expectedType
     * @return bool
     * @throws Type\PdfTypeException
     */
    protected function ensureExpectedType($token, $expectedType)
    {
        static $mapping = ['(' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfString::class, '<' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfHexString::class, '<<' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfDictionary::class, '/' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfName::class, '[' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfArray::class, 'true' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfBoolean::class, 'false' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfBoolean::class, 'null' => \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfNull::class];
        if ($expectedType === null || $mapping[$token] === $expectedType) {
            return \true;
        }
        throw new \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException('Got unexpected token type.', \FlexibleCouponsVendor\setasign\Fpdi\PdfParser\Type\PdfTypeException::INVALID_DATA_TYPE);
    }
}
