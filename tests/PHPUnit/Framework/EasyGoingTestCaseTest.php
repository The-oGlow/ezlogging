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

/**
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols.
 */
class EasyGoingTestCaseO2t
{
}

class EasyGoingTestCaseClazz extends EasyGoingTestCase // NOSONAR php:S3360
{
    public const EASYGOINGTESTCASETEXT_PUBLIC = 'public';

    protected const EASYGOINGTESTCASETEXT_PROTECTED = 'protected';

    private const EASYGOINGTESTCASETEXT_PRIVATE = 'private'; // @phpstan-ignore classConstant.unused

    public const EASYGOINGTESTCASETEXT_NONE = 'none';

    protected function prepareO2t()
    {
        return new EasyGoingTestCaseO2t();
    }

    protected function getCasto2t(): EasyGoingTestCaseO2t
    {
        return $this->o2t;
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return mixed
     */
    public static function getConstValue($clazz, string $constantName)
    {
        return parent::getConstValue($clazz, $constantName);
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return bool
     */
    public static function isConstExist($clazz, string $constantName): bool
    {
        return parent::isConstExist($clazz, $constantName);
    }
}

class EasyGoingTestCaseTest extends TestCase
{
    use UnavailableMethodsTrait;
    use UnavailableFieldsTrait;

    private const TEST_CLAZZ = '\PHPUnit\Framework\EasyGoingTestCaseClazz';

    /** @var EasyGoingTestCaseClazz */
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
        $actual   = $this->callMethodOnO2t('prepareO2t');

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
        $actual   = $this->callMethodOnO2t('getCasto2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseO2t::class, $actual);
        static::assertEquals($expected, $actual);
        static::assertSame($expected, $actual);
    }

    public function testGetConstValueWithPublic(): void
    {
        $expected = 'public';
        $actual = $this->o2t::getConstValue($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PUBLIC');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testGetConstValueWithProtected(): void
    {
        $expected = 'protected';
        $actual = $this->o2t::getConstValue($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PROTECTED');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testGetConstValueWithPrivate(): void
    {
        $expected = 'private';
        $actual = $this->o2t::getConstValue($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PRIVATE');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testGetConstValueWithNone(): void
    {
        $expected = 'none';
        $actual = $this->o2t::getConstValue($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_NONE');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testGetConstValueWithNotExists(): void
    {
        $expected = '';
        $actual = $this->o2t::getConstValue($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_NOTEXISTS');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsConstExistWithPublic(): void
    {
        $expected = true;
        $actual = $this->o2t::isConstExist($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PUBLIC');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsConstExistWithProtected(): void
    {
        $expected = true;
        $actual = $this->o2t::isConstExist($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PROTECTED');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsConstExistWithPrivate(): void
    {
        $expected = true;
        $actual = $this->o2t::isConstExist($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_PRIVATE');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsConstExistWithNone(): void
    {
        $expected = true;
        $actual = $this->o2t::isConstExist($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_NONE');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsConstExistWithNotExists(): void
    {
        $expected = false;
        $actual = $this->o2t::isConstExist($this->o2t, self::TEST_CLAZZ . '::EASYGOINGTESTCASETEXT_NOTEXISTS');

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }
}
