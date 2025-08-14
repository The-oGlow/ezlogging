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

use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\PaddingProcessor;
use Monolog\Processor\ProcessorInterface;

class ConsoleLogger extends AbstractEasyGoingLogger
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return $this->getConsoleHandler();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PaddingProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new EasyGoingFormatter();
    }
}
