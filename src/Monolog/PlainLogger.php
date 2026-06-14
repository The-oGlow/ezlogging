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

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\PlainProcessor;
use Monolog\Processor\ProcessorInterface;
use Psr\Log\LogLevel;

/**
 * Class PlainLogger.
 *
 * @see AbstractEasyGoingLogger
 */
class PlainLogger extends AbstractEasyGoingLogger
{
    #[\Override]
    protected function getDefaultHandler(int|string|Level $level = self::LEVEL_DEFAULT): HandlerInterface
    {
        return $this->getConsoleHandler($level);
    }

    #[\Override]
    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    #[\Override]
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }

    /**
     * @param string|\Stringable $message The log message
     * @param mixed              $level
     */
    public function out(string|\Stringable $message, $level = self::LEVEL_DEFAULT): void
    {
        parent::log($level, $message);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function log($level, string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, $level);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function emergency(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::EMERGENCY);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function alert(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::ALERT);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function warning(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::WARNING);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function notice(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::NOTICE);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function info(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::INFO);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function debug(string|\Stringable $message, mixed $context = []): void
    {
        $this->out($message, LogLevel::DEBUG);
    }
}
