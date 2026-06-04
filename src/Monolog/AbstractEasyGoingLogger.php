<?php

declare(strict_types=1);

/*
 * This file is part of ezlogging
 *
 * (c) 2025 Oliver Glowa, coding.glowa.com
 *
 * This source file is subject to the Apache-2.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Monolog;

use DateTimeZone;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\ProcessorInterface;
use Psr\Log\LogLevel;

/**
 * Class AbstractEasyGoingLogger.
 *
 * @see Logger
 * @see ConsoleHandler
 *
 * @phpstan-type LevelEnum 100|200|250|300|400|500|550|600|'ALERT'|'alert'|'CRITICAL'|'critical'|'DEBUG'|'debug'|'EMERGENCY'|'emergency'|'ERROR'|'error'|'INFO'|'info'|'NOTICE'|'notice'|'WARNING'|'warning'
 */
abstract class AbstractEasyGoingLogger extends Logger
{
    /** Fallback timezone */
    public const string STANDARD_TIMEZONE = "Europe/Berlin";

    /** Default output level (INFO) */
    public const string LEVEL_DEFAULT = LogLevel::INFO;

    /**
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param mixed              $level      The output level (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     * @param HandlerInterface[] $handlers   optional stack of handlers, the first one in the array is called first, etc
     * @param callable[]         $processors Optional array of processors
     * @param null|DateTimeZone  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     */
    public function __construct(string $name, mixed $level = self::LEVEL_DEFAULT, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        if (empty($timezone)) {
            /**
             * @psalm-suppress RedundantCondition,TypeDoesNotContainNull
             * @phpstan-ignore nullCoalesce.expr
             */
            $timezone = new DateTimeZone(date_default_timezone_get() ?? self::STANDARD_TIMEZONE);
        }
        parent::__construct($name, $handlers, $processors, $timezone);

        $this->pushHandler($this->getDefaultHandler($level));

        $this->pushProcessor($this->getDefaultProcessor());
    }

    /**
     * @param mixed $level Output level (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @
     *
     * @return HandlerInterface
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     */
    abstract protected function getDefaultHandler(mixed $level = self::LEVEL_DEFAULT): HandlerInterface;

    /**
     * @return ProcessorInterface
     */
    abstract protected function getDefaultProcessor(): ProcessorInterface;

    /**
     * @return FormatterInterface
     */
    abstract protected function getDefaultFormatter(): FormatterInterface;

    /**
     * @param mixed $level Output level (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @return StreamHandler the stream handler for the file
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     */
    protected function getConsoleHandler(mixed $level = self::LEVEL_DEFAULT): StreamHandler
    {
        $consoleHandler = new ConsoleHandler($level);
        $consoleHandler->setFormatter($this->getDefaultFormatter());

        return $consoleHandler;
    }
}
