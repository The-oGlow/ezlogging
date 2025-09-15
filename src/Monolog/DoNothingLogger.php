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

use Handler\NoopHandler;

/**
 * This logger does exactly: <strong>nothing</strong>!
 */
class DoNothingLogger extends Logger {

    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null) {
        parent::__construct(
                $name,
                [new NoopHandler()],
                [],
                $timezone
        );
    }
}
