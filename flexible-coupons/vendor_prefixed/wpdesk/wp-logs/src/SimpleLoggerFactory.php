<?php

declare (strict_types=1);
namespace FlexibleCouponsVendor\WPDesk\Logger;

use FlexibleCouponsVendor\Monolog\Handler\FingersCrossedHandler;
use FlexibleCouponsVendor\Monolog\Handler\HandlerInterface;
use FlexibleCouponsVendor\Monolog\Logger;
use FlexibleCouponsVendor\Monolog\Handler\ErrorLogHandler;
use FlexibleCouponsVendor\Monolog\Processor\PsrLogMessageProcessor;
use FlexibleCouponsVendor\Monolog\Processor\UidProcessor;
use Psr\Log\LogLevel;
use FlexibleCouponsVendor\WPDesk\Logger\WC\WooCommerceHandler;
final class SimpleLoggerFactory implements \FlexibleCouponsVendor\WPDesk\Logger\LoggerFactory
{
    /**
     * @var array{
     *   level?: string,
     *   action_level?: string|null,
     * }
     */
    private $options;
    /** @var string */
    private $channel;
    /** @var Logger */
    private $logger;
    /**
     * Valid options are:
     *   * level (default debug): Default logging level
     *   * action_level: If value is set, it will act as the minimum level at which logger will be triggered using FingersCrossedHandler {@see https://seldaek.github.io/monolog/doc/02-handlers-formatters-processors.html#wrappers--special-handlers}
     */
    public function __construct(string $channel, $options = null)
    {
        $this->channel = $channel;
        $options = $options ?? new \FlexibleCouponsVendor\WPDesk\Logger\Settings();
        if ($options instanceof \FlexibleCouponsVendor\WPDesk\Logger\Settings) {
            $options = $options->to_array();
        }
        $this->options = \array_merge(['level' => \Psr\Log\LogLevel::DEBUG, 'action_level' => null], $options);
    }
    public function getLogger($name = null) : \FlexibleCouponsVendor\Monolog\Logger
    {
        if ($this->logger) {
            return $this->logger;
        }
        $this->logger = new \FlexibleCouponsVendor\Monolog\Logger($this->channel, [], [new \FlexibleCouponsVendor\Monolog\Processor\PsrLogMessageProcessor(null, \true), new \FlexibleCouponsVendor\Monolog\Processor\UidProcessor()], \wp_timezone());
        if (\function_exists('wc_get_logger') && \did_action('woocommerce_init')) {
            $this->set_wc_handler();
        } else {
            \add_action('woocommerce_init', [$this, 'set_wc_handler']);
        }
        // In the worst-case scenario, when WC logs are not available (yet, or at all),
        // fallback to WP logs, but only when enabled.
        if (empty($this->logger->getHandlers()) && \defined('FlexibleCouponsVendor\\WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            $this->set_handler($this->logger, new \FlexibleCouponsVendor\Monolog\Handler\ErrorLogHandler(\FlexibleCouponsVendor\Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, $this->options['level']));
        }
        return $this->logger;
    }
    /**
     * @internal
     */
    public function set_wc_handler() : void
    {
        $this->set_handler($this->logger, new \FlexibleCouponsVendor\WPDesk\Logger\WC\WooCommerceHandler(\wc_get_logger(), $this->channel));
    }
    private function set_handler(\FlexibleCouponsVendor\Monolog\Logger $logger, \FlexibleCouponsVendor\Monolog\Handler\HandlerInterface $handler) : void
    {
        if (\is_string($this->options['action_level'])) {
            $handler = new \FlexibleCouponsVendor\Monolog\Handler\FingersCrossedHandler($handler, $this->options['action_level']);
        }
        // Purposefully replace all existing handlers.
        $logger->setHandlers([$handler]);
    }
}
