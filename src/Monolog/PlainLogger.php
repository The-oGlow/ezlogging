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

/**
 * Class PlainLogger.
 *
 * @see AbstractEasyGoingLogger
 */
class PlainLogger extends AbstractEasyGoingLogger
{
    #[\Override]
    protected function getDefaultHandler($level = self::LEVEL_DEFAULT): HandlerInterface
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
     */
    public function out($message): void
    {
        parent::info($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     *
     * @phpstan-ignore method.childParameterType
     */
    #[\Override]
    public function log($level, $message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function emergency($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function alert($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function warning($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function notice($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function info($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function debug($message, array $context = []): void
    {
        $this->out($message);
    }
}
