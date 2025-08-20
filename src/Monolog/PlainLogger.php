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
use Stringable;

class PlainLogger extends AbstractEasyGoingLogger
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return $this->getConsoleHandler();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }

    /**
     * @param string|Stringable $message
     */
    public function out($message): void
    {
        parent::info($message);
    }

    /**
     * @param mixed             $level
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function log($level, $message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function emergency($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function alert($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function warning($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function notice($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function info($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     */
    public function debug($message, array $context = []): void
    {
        $this->out($message);
    }
}
