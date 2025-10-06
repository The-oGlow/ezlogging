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
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\NoopHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\PlainProcessor;
use Monolog\Processor\ProcessorInterface;

/**
 * This logger does exactly: <strong>nothing</strong>!
 */
class DoNothingLogger extends AbstractEasyGoingLogger
{
    public function __construct()
    {
        parent::__construct(
            self::class,
            [],
            [],
            null
        );
    }

    protected function getDefaultHandler(): HandlerInterface
    {
        return new NoopHandler();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }
}
