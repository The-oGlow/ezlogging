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

namespace Monolog\Processor;

use Monolog\LogRecord;

class PlainProcessor implements ProcessorInterface
{
    /**
     * @param LogRecord $record A record
     *
     * @return LogRecord The processed record
     */
    #[\Override]
    public function __invoke(LogRecord $record): LogRecord
    {
        return $record;
    }
}
