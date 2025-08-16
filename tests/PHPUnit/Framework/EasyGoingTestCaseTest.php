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

namespace PHPUnit\Framework;

use ollily\Tools\Reflection\UnavailableFieldsTrait;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\TestCase;

class EasyGoingTestCaseO2t
{
};
class EasyGoingTestCaseClazz extends EasyGoingTestCase //NOSONAR php:S3360
{
    protected function prepareO2t(): mixed
    {
        return new EasyGoingTestCaseO2t();
    }

    protected function getCasto2t(): EasyGoingTestCaseO2t
    {
        return $this->o2t;
    }
}

class EasyGoingTestCaseTest extends TestCase
{
    use UnavailableMethodsTrait;
    use UnavailableFieldsTrait;

    /** @var EasyGoingTestCaseClazz $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new EasyGoingTestCaseClazz();
        $this->o2t->setUp();
    }

    public function testPrepareO2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual = $this->callMethodOnO2t('prepareO2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $actual);
        static::assertNotSame($expected, $actual);
        static::assertEquals($expected, $actual);
    }

    public function testGetCasto2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual = $this->callMethodOnO2t('getCasto2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $actual);
        static::assertEquals($expected, $actual);
        static::assertSame($expected, $actual);
    }
}
