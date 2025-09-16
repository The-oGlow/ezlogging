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
use Monolog\Handler\NoopHandler;
use Monolog\Handler\HandlerInterface;

/**
 * This logger does exactly: <strong>nothing</strong>!
 */
class DoNothingLogger extends Logger
{
    /**
     * DoNothingLogger constructor.
     *
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc
     * @param callable[]         $processors Optional array of processors
     * @param null|DateTimeZone  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     *
     * @phpstan-ignore constructor.unusedParameter,constructor.unusedParameter
     */
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct(
            $name,
            [new NoopHandler()],
            [],
            $timezone
        );
    }
}
