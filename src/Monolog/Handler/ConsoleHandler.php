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

use Monolog\Level;
use Psr\Log\LogLevel;

/**
 * Class ConsoleHandler.
 *
 * @see StreamHandler
 */
class ConsoleHandler extends StreamHandler
{
    /** @var string Standard output stream */
    public const HANDLER_STDOUT = "php://stdout";

    /** @var string Default output level (INFO) */
    public const LEVEL_DEFAULT =  LogLevel::INFO;

    /**
     * ConsoleHandler constructor.
     *
     * @param mixed $level The output level (Default: {@link ConsoleHandler::LEVEL_DEFAULT})
     *
     * @see ConsoleHandler::LEVEL_DEFAULT;
     * @see ConsoleHandler::HANDLER_STDOUT;
     */
    public function __construct($level = self::LEVEL_DEFAULT)
    {
        parent::__construct(self::HANDLER_STDOUT, $level);
    }
}
