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

use Monolog;

class PlainProcessor implements ProcessorInterface
{
    /**
     * @param mixed[] $record
     *
     * @return mixed[] The processed record
     *
     * @phpstan-ignore method.childReturnType
     */
    public function __invoke(array $record)
    {
        return $record;
    }
}
