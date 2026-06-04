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

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

/**
 * A simple clazz which will be tested by the test clazz.
 */
class AbstractEasyGoingLoggerTestFormatterDummyClazz implements FormatterInterface
{
    #[\Override]
    public function format(LogRecord $record): mixed
    {
        return $record;
    }

    #[\Override]
    public function formatBatch(array $records): mixed
    {
        return $records;
    }
}
