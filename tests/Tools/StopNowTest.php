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
    public function testStopDefault(): void
    {
        $errCode    = 0;
        $errMessage = '';

        $expected = StopNow::ERR_CODE_DEFAULT;

        $actual = StopNow::stop($errCode, $errMessage, true);

        static::assertEquals($expected, $actual);
    }

    public function testStopSpecific(): void
    {
        $errCode    = 123;
        $errMessage = 'There is something worried';

        $expected = 123;

        $actual = StopNow::stop($errCode, $errMessage, true);

        static::assertEquals($expected, $actual);
    }

    public function testStopErrorCodeToLow(): void
    {
        $errCode    = -1;
        $errMessage = '';

        $expected = StopNow::ERR_CODE_DEFAULT;

        $actual = StopNow::stop($errCode, $errMessage, true);

        static::assertEquals($expected, $actual);
    }

    public function testStopErrorCodeToHigh(): void
    {
        $errCode    = 255;
        $errMessage = '';

        $expected = StopNow::ERR_CODE_DEFAULT;

        $actual = StopNow::stop($errCode, $errMessage, true);

        static::assertEquals($expected, $actual);
    }
}
