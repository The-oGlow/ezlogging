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

namespace ollily\Tools;

use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Monolog\Processor\PaddingProcessor;
use Psr\Log\LoggerInterface;

class StopNow
{
    public const  ERR_MSG_DEFAULT = 'Undefined reason to stop now!';
    public const  ERR_CODE_DEFAULT = 1;
    private const ERR_CODE_MAX = 254;

    /** @var LoggerInterface */
    private static $logger;

    private function __construct()
    {
        self::init();
    }

    private static function init(): void
    {
        /**
         * @psalm-suppress  DocblockTypeContradiction
         * @phpstan-ignore  function.impossibleType
         *  */
        if (is_null(self::$logger)) {
            $handler = new ErrorLogHandler();
            $handler->setFormatter(new EasyGoingFormatter());
            self::$logger = new Logger(StopNow::class, [$handler], [new PaddingProcessor()]);
        }
    }

    /**
     * @return LoggerInterface
     */
    private static function getLogger(): LoggerInterface
    {
        self::init();

        return self::$logger;
    }

    /**
     * @param \Throwable $throwable
     * @param bool       $unitTest TRUE=don't call exit(), it's an unit test (Default: FALSE)
     *
     * @return int errorcode
     *
     * @SuppressWarnings("PHPMD.ExitExpression")
     */
    public static function stopException(\Throwable $throwable, bool $unitTest = false): int
    {
        $errMsg = sprintf('{%s} - %s', get_class($throwable), $throwable->getMessage());

        return static::stop($throwable->getCode(), $errMsg, $unitTest);
    }

    /**
     * @param int    $errorCode
     * @param string $errorMessage
     * @param bool   $unitTest TRUE=don't call exit(), it's an unit test (Default: FALSE)
     *
     * @return int errorcode
     *
     * @SuppressWarnings("PHPMD.ExitExpression")
     */
    public static function stop(int $errorCode = self::ERR_CODE_DEFAULT, string $errorMessage = '', bool $unitTest = false): int
    {
        if ($errorCode < self::ERR_CODE_DEFAULT || $errorCode > self::ERR_CODE_MAX) {
            $errorCode = self::ERR_CODE_DEFAULT;
        }
        if (empty($errorMessage)) {
            $errorMessage = self::ERR_MSG_DEFAULT;
        }
        self::getLogger()->emergency($errorMessage, [$errorCode]);
        if (!$unitTest) {
            die($errorCode);
        } else {
            return $errorCode;
        }
    }
}
