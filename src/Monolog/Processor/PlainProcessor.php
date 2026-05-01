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

/**
 * Class PlainProcessor.
 *
 * @phpstan-import-type Level from \Monolog\Logger
 * @phpstan-import-type LevelName from \Monolog\Logger
 * @phpstan-import-type Record from \Monolog\Logger
 */
class PlainProcessor implements ProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(array $record)
    {
        return $record;
    }
}
