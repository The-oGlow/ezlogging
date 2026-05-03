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

namespace Monolog\AbstractEasyGoingLoggerTest;

use Monolog\AbstractEasyGoingLogger;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\ProcessorInterface;

/**
 * A simple clazz which will be tested by the test clazz.
 */
class AbstractEasyGoingLoggerTestDummyClazz extends AbstractEasyGoingLogger
{
    /**
     * @inheritdoc
     */
    protected function getDefaultHandler($level = self::LEVEL_DEFAULT): HandlerInterface
    {
        return new AbstractEasyGoingLoggerTestHandlerDummyClazz();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new AbstractEasyGoingLoggerTestProcessorDummyClazz();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new AbstractEasyGoingLoggerTestFormatterDummyClazz();
    }
}
