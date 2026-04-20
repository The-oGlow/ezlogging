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

/**
 * Class ConsoleLogger.
 *
 * @see AbstractEasyGoingLogger
 * @see PaddingProcessor
 * @see EasyGoingFormatter
 */
class ConsoleLogger extends AbstractEasyGoingLogger
{
    /**
     * @inheritdoc
     */
    protected function getDefaultHandler($level = self::LEVEL_DEFAULT): HandlerInterface
    {
        return $this->getConsoleHandler($level);
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PaddingProcessor();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new EasyGoingFormatter();
    }
}
