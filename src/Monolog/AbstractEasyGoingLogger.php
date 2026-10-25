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

/**
 * Class AbstractEasyGoingLogger.
 *
 * @see Logger
 * @see ConsoleHandler
 */
abstract class AbstractEasyGoingLogger extends LoggerAdapter
{
    /**
     * @param string                 $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param list<HandlerInterface> $handlers   optional stack of handlers, the first one in the array is called first, etc
     * @param callable[]             $processors Optional array of processors
     * @param null|DateTimeZone      $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     * @param int|Level|string       $level      The minimum logging level at which this handler will be triggered
     *                                           (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @phpstan-param array<(callable(\Monolog\LogRecord): \Monolog\LogRecord)|\Monolog\Processor\ProcessorInterface> $processors
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     */
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null, mixed $level = self::LEVEL_DEFAULT)
    {
        if (empty($timezone)) {
            $timezone = new DateTimeZone(date_default_timezone_get());
        }

        parent::__construct($name, $handlers, $processors, $timezone);
        parent::pushHandler($this->getDefaultHandler($level));
        parent::pushProcessor($this->getDefaultProcessor());
    }

    /**
     * @param int|Level|string $level The minimum logging level at which this handler will be triggered
     *                                (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     *
     * @return HandlerInterface
     */
    abstract protected function getDefaultHandler(int|string|Level $level = self::LEVEL_DEFAULT): HandlerInterface;

    /**
     * @return ProcessorInterface
     */
    abstract protected function getDefaultProcessor(): ProcessorInterface;

    /**
     * @return FormatterInterface
     */
    abstract protected function getDefaultFormatter(): FormatterInterface;

    /**
     * @param int|Level|string $level The minimum logging level at which this handler will be triggered
     *                                (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     *
     * @return StreamHandler the stream handler for the file
     */
    protected function getConsoleHandler(int|string|Level $level = self::LEVEL_DEFAULT): StreamHandler
    {
        $consoleHandler = new ConsoleHandler($level);
        $consoleHandler->setFormatter($this->getDefaultFormatter());

        return $consoleHandler;
    }
}
