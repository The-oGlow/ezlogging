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
use Monolog\Handler\FileHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\ProcessorInterface;

/**
 * Class AbstractEasyGoingLogger
 *
 * @package Monolog
 */
abstract class AbstractEasyGoingLogger extends Logger
{
    public const STANDARD_TIMEZONE = "Europe/Berlin";
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @var string $targetFile
     */
    protected $targetFile;

    /**
     * AbstractEasyGoingLogger constructor.
     *
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     * @param DateTimeZone|null  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     */
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct(
            $name,
            $handlers,
            $processors,
            $timezone ?? new DateTimeZone(
                !empty(date_default_timezone_get()) ? date_default_timezone_get() : self::STANDARD_TIMEZONE
            ) // NOSONAR:  php:S2830
        );
        $this->pushProcessor($this->getDefaultProcessor());
        $this->pushHandler($this->getConsoleHandler());
    }

    abstract protected function getDefaultHandler(): HandlerInterface;

    abstract protected function getDefaultProcessor(): ProcessorInterface;

    abstract protected function getDefaultFormatter(): FormatterInterface;

    protected function getConsoleHandler(): StreamHandler
    {
        $consoleHandler = new ConsoleHandler();
        $consoleHandler->setFormatter($this->getDefaultFormatter());

        return $consoleHandler;
    }
}
