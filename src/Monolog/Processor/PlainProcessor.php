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
 * @phpstan-import-type Level from \Monolog\Logger
 * @phpstan-import-type LevelName from \Monolog\Logger
 *
 * @phpstan-type Record array<mixed,mixed>
 */
class PlainProcessor implements ProcessorInterface
{
    /**
     * @param array $record A record
     *
     * @phpstan-param Record $record A record
     *
     * @return array The processed record
     *
     * @phpstan-return Record
     *
     * @phpstan-ignore method.childReturnType
     */
    public function __invoke(array $record)
    {
        return $record;
    }
}
