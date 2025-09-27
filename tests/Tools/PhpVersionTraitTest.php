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

class PhpVersionTraitTest extends TestCase
{
    use PhpVersionTrait;

    private function validateResult(string $checkVersion, bool $expected):void
    {
        $actual = $this->isPhpGreater($checkVersion);
        static::assertEquals($expected, $actual);
    }

    public function testPhpVersionEqual(): void
    {
        $checkVersion = PHP_VERSION;

        $this->validateResult($checkVersion, true);
    }

    public function testPhpVersionLower(): void
    {
        $checkVersion = '1.0';

        $this->validateResult($checkVersion, true);
    }

    public function testPhpVersionHigher(): void
    {
        $checkVersion = '99.99.999';

        $this->validateResult($checkVersion, false);
    }

    public function ztestPhpVersionWrong(): void
    {
        $checkVersion = 'JustAText';

        $this->validateResult($checkVersion, false);
    }
}
