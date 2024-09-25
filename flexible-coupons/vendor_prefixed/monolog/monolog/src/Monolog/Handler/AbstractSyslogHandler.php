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
use FlexibleCouponsVendor\Monolog\Formatter\FormatterInterface;
use FlexibleCouponsVendor\Monolog\Formatter\LineFormatter;
/**
 * Common syslog functionality
 *
 * @phpstan-import-type Level from \Monolog\Logger
 */
abstract class AbstractSyslogHandler extends \FlexibleCouponsVendor\Monolog\Handler\AbstractProcessingHandler
{
    /** @var int */
    protected $facility;
    /**
     * Translates Monolog log levels to syslog log priorities.
     * @var array
     * @phpstan-var array<Level, int>
     */
    protected $logLevels = [\FlexibleCouponsVendor\Monolog\Logger::DEBUG => \LOG_DEBUG, \FlexibleCouponsVendor\Monolog\Logger::INFO => \LOG_INFO, \FlexibleCouponsVendor\Monolog\Logger::NOTICE => \LOG_NOTICE, \FlexibleCouponsVendor\Monolog\Logger::WARNING => \LOG_WARNING, \FlexibleCouponsVendor\Monolog\Logger::ERROR => \LOG_ERR, \FlexibleCouponsVendor\Monolog\Logger::CRITICAL => \LOG_CRIT, \FlexibleCouponsVendor\Monolog\Logger::ALERT => \LOG_ALERT, \FlexibleCouponsVendor\Monolog\Logger::EMERGENCY => \LOG_EMERG];
    /**
     * List of valid log facility names.
     * @var array<string, int>
     */
    protected $facilities = ['auth' => \LOG_AUTH, 'authpriv' => \LOG_AUTHPRIV, 'cron' => \LOG_CRON, 'daemon' => \LOG_DAEMON, 'kern' => \LOG_KERN, 'lpr' => \LOG_LPR, 'mail' => \LOG_MAIL, 'news' => \LOG_NEWS, 'syslog' => \LOG_SYSLOG, 'user' => \LOG_USER, 'uucp' => \LOG_UUCP];
    /**
     * @param string|int $facility Either one of the names of the keys in $this->facilities, or a LOG_* facility constant
     */
    public function __construct($facility = \LOG_USER, $level = \FlexibleCouponsVendor\Monolog\Logger::DEBUG, bool $bubble = \true)
    {
        parent::__construct($level, $bubble);
        if (!\defined('PHP_WINDOWS_VERSION_BUILD')) {
            $this->facilities['local0'] = \LOG_LOCAL0;
            $this->facilities['local1'] = \LOG_LOCAL1;
            $this->facilities['local2'] = \LOG_LOCAL2;
            $this->facilities['local3'] = \LOG_LOCAL3;
            $this->facilities['local4'] = \LOG_LOCAL4;
            $this->facilities['local5'] = \LOG_LOCAL5;
            $this->facilities['local6'] = \LOG_LOCAL6;
            $this->facilities['local7'] = \LOG_LOCAL7;
        } else {
            $this->facilities['local0'] = 128;
            // LOG_LOCAL0
            $this->facilities['local1'] = 136;
            // LOG_LOCAL1
            $this->facilities['local2'] = 144;
            // LOG_LOCAL2
            $this->facilities['local3'] = 152;
            // LOG_LOCAL3
            $this->facilities['local4'] = 160;
            // LOG_LOCAL4
            $this->facilities['local5'] = 168;
            // LOG_LOCAL5
            $this->facilities['local6'] = 176;
            // LOG_LOCAL6
            $this->facilities['local7'] = 184;
            // LOG_LOCAL7
        }
        // convert textual description of facility to syslog constant
        if (\is_string($facility) && \array_key_exists(\strtolower($facility), $this->facilities)) {
            $facility = $this->facilities[\strtolower($facility)];
        } elseif (!\in_array($facility, \array_values($this->facilities), \true)) {
            throw new \UnexpectedValueException('Unknown facility value "' . $facility . '" given');
        }
        $this->facility = $facility;
    }
    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter() : \FlexibleCouponsVendor\Monolog\Formatter\FormatterInterface
    {
        return new \FlexibleCouponsVendor\Monolog\Formatter\LineFormatter('%channel%.%level_name%: %message% %context% %extra%');
    }
}
