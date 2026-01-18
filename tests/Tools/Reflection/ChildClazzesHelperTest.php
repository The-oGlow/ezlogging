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

namespace ollily\Tools\Reflection;

use PHPUnit\Framework\TestCase;

class ChildClazzesHelperTest extends TestCase
{
    public function testNoChildren(): void
    {
        $clazzName = ChildClazzesHelperTest::class;
        $expected = 0;

        $actual = ChildClazzesHelper::getAllChildren($clazzName);

        static::assertEquals($expected, sizeof($actual));
        static::assertNotContains($clazzName, $actual);
    }

    public function testOneOrManyChildren(): void
    {
        $clazzName = TestCase::class;
        $expected = 1;

        $actual = ChildClazzesHelper::getAllChildren($clazzName);

        static::assertGreaterThanOrEqual($expected, sizeof($actual));
        static::assertContains(ChildClazzesHelperTest::class, $actual);
        static::assertNotContains($clazzName, $actual);
    }

    public function testClazzNotExists(): void
    {
        $clazzName = 'ClazzNotExists';
        $expected = 0;

        $actual = ChildClazzesHelper::getAllChildren($clazzName);

        static::assertEquals($expected, sizeof($actual));
        static::assertNotContains($clazzName, $actual);
    }
}
