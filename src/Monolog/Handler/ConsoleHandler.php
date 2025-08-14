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

namespace Monolog\Handler;

use Monolog\Logger;

class ConsoleHandler extends StreamHandler
{
    public const HANDLER_STDOUT    = "php://stdout";

    public function __construct()
    {
        parent::__construct(self::HANDLER_STDOUT);
    }
}
