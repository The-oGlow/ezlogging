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
    public const string HANDLER_STDOUT = "php://stdout";

    /** @var string Default output level */
    public const string LEVEL_DEFAULT = LogLevel::INFO;

    /**
     * ConsoleHandler constructor.
     *
     * @param int|Level|LogLevel|string $level The minimum logging level at which this handler will be triggered
     *                                         (Default: {@link self::LEVEL_DEFAULT})
     *
     * @throws \InvalidArgumentException If stream is not a resource or string
     *
     * @see ConsoleHandler::LEVEL_DEFAULT;
     */
    public function __construct(int|string|Level|LogLevel $level = self::LEVEL_DEFAULT)
    {
        /** @psalm-suppress PossiblyInvalidArgument
         * @phpstan-ignore argument.type */
        parent::__construct(self::HANDLER_STDOUT, $level);
    }
}
