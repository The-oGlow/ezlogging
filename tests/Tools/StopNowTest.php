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

use PHPUnit\Framework\TestCase;

class StopNowTest extends TestCase
{
    public const CODE_NEG1     = -1;

    public const CODE_0        = 0;

    public const CODE_89       = 89;

    public const CODE_123      = 123;

    public const CODE_255      = 255;

    public const ERR_MSG_EMPTY = '';

    public const ERR_MSG_01    = 'ERR-MSG';

    public const ERR_MSG_02    = 'There is something worried';

    /**
     * @param int    $errCode
     * @param string $errMessage
     * @param int    $expected
     *
     * @dataProvider providerStopNow
     */
    public function testStop(int $errCode, string $errMessage, int $expected): void
    {
        $actual = StopNow::stop($errCode, $errMessage, true);

        self::assertEquals($expected, $actual);
    }

    /**
     * @param \Throwable $throwable
     * @param int        $expected
     *
     * @dataProvider providerStopNowException
     */
    public function testStopException(\Throwable $throwable, int $expected): void
    {
        $actual = StopNow::stopException($throwable, true);

        self::assertEquals($expected, $actual);
    }

    // Dataprovider

    /**
     * @return array<mixed,mixed>
     */
    public function providerStopNow(): array
    {
        return [
            'Default' => [self::CODE_0, self::ERR_MSG_EMPTY, StopNow::ERR_CODE_DEFAULT],
            'Specific' => [self::CODE_123, self::ERR_MSG_02, self::CODE_123],
            'ErrorCodeToLow' => [self::CODE_NEG1, self::ERR_MSG_EMPTY, StopNow::ERR_CODE_DEFAULT],
            'ErrorCodeToHigh' => [self::CODE_255, self::ERR_MSG_EMPTY, StopNow::ERR_CODE_DEFAULT],
        ];
    }

    /**
     * @return array<mixed,mixed>
     */
    public function providerStopNowException(): array
    {
        return [
            'Default' => [new \Exception(), StopNow::ERR_CODE_DEFAULT],
            'Specific' => [new \RuntimeException(),StopNow::ERR_CODE_DEFAULT],
            'ErrCode' => [new \RuntimeException(self::ERR_MSG_EMPTY, self::CODE_89), self::CODE_89],
            'ErrCodeToLow' => [new \RuntimeException(self::ERR_MSG_EMPTY, self::CODE_NEG1), StopNow::ERR_CODE_DEFAULT],
            'ErrCodeToHigh' => [new \RuntimeException(self::ERR_MSG_EMPTY, self::CODE_255), StopNow::ERR_CODE_DEFAULT],
            'ErrMsg' => [new \Error(self::ERR_MSG_01), StopNow::ERR_CODE_DEFAULT],
            'ErrMsgCode' => [new \Error(self::ERR_MSG_01, self::CODE_123), self::CODE_123],
            ];
    }
}
