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
use Monolog\Handler\NoopHandler;
use Monolog\Processor\PlainProcessor;
use Monolog\Processor\ProcessorInterface;

/**
 * Class DoNothingLogger.
 *
 * This logger does exactly: <strong>nothing</strong>!
 *
 * @see AbstractEasyGoingLogger
 * @see NoopHandler
 * @see PlainProcessor
 * @see PlainFormatter
 */
class DoNothingLogger extends AbstractEasyGoingLogger
{
    /**
     * @psalm-suppress MethodSignatureMismatch
     */
    public function __construct()
    {
        parent::__construct(DoNothingLogger::class, self::LEVEL_DEFAULT, [], [], null);
    }

    #[\Override]
    protected function getDefaultHandler($level = self::LEVEL_DEFAULT): HandlerInterface
    {
        return new NoopHandler();
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
}
