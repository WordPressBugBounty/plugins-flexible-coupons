<?php

declare (strict_types=1);
/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FlexibleCouponsVendor\Monolog\Handler;

use FlexibleCouponsVendor\Monolog\Logger;
use FlexibleCouponsVendor\Monolog\Formatter\NormalizerFormatter;
use FlexibleCouponsVendor\Monolog\Formatter\FormatterInterface;
use FlexibleCouponsVendor\Doctrine\CouchDB\CouchDBClient;
/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends \FlexibleCouponsVendor\Monolog\Handler\AbstractProcessingHandler
{
    /** @var CouchDBClient */
    private $client;
    public function __construct(\FlexibleCouponsVendor\Doctrine\CouchDB\CouchDBClient $client, $level = \FlexibleCouponsVendor\Monolog\Logger::DEBUG, bool $bubble = \true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record) : void
    {
        $this->client->postDocument($record['formatted']);
    }
    protected function getDefaultFormatter() : \FlexibleCouponsVendor\Monolog\Formatter\FormatterInterface
    {
        return new \FlexibleCouponsVendor\Monolog\Formatter\NormalizerFormatter();
    }
}
