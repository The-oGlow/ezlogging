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

namespace PHPUnit\Framework\EasyGoingTestCaseTest;

use Monolog\ConsoleLogger;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * This is the test clazz which will test the test clazz.
 *
 * @see EasyGoingTestCaseClazz
 */
class EasyGoingTestCaseTest extends TestCase
{
    use UnavailableMethodsTrait;
    use UnavailableFieldsTrait;

    /** @var EasyGoingTestCaseClazz */
    protected $o2t;

    /** @var LoggerInterface */
    private static $logger;

    /**
     * @return EasyGoingTestCaseClazz
     */
    protected static function prepareO2t()
    {
        return new EasyGoingTestCaseClazz();
    }

    /**
     * @return mixed[]
     */
    protected static function prepareAllConsts(): array
    {
        return EasyGoingTestCaseClazz::prepareAllConsts();
    }

    /**
     * @param mixed   $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        self::$logger = new ConsoleLogger(EasyGoingTestCaseTest::class);
        self::$logger->debug('START');
        parent::__construct($name, $data, $dataName);
        self::$logger->debug('END');
    }

    public function setUp(): void
    {
        self::$logger->debug('START');
        parent::setUp();
        $this->o2t = self::prepareO2t();
        $this->o2t->setUp();
        self::$logger->debug('END');
    }

    // Test functions

    public function testPrepareO2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual   = $this->callMethodOnO2t('prepareO2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseDummyClazz::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseDummyClazz::class, $actual);
        static::assertNotSame($expected, $actual);
        static::assertEquals($expected, $actual);
    }

    public function testGetCasto2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual   = $this->callMethodOnO2t('getCasto2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseDummyClazz::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseDummyClazz::class, $actual);
        static::assertEquals($expected, $actual);
        static::assertSame($expected, $actual);
    }

    public function testTestInit(): void
    {
        try {
            $this->o2t->testInit();
        } catch (\Exception $e) {
            static::fail('Should not raise any exection: ' . $e->getMessage());
        }
    }

    /**
     * @param bool   $expectedBool
     * @param string $constName
     *
     * @dataProvider prepareDataProvider
     */
    public function testIsConstExist(bool $expectedBool, string $constName): void
    {
        self::$logger->info('parameters', [$expectedBool, $constName]);

        $actual = $this->o2t::publicIsConstExist($this->o2t->publicGetCastO2t(), $constName);

        self::$logger->debug('comparing', [$expectedBool, $actual]);

        static::assertEquals($expectedBool, $actual, "Not equals: '$expectedBool'='$actual'");
    }

    /**
     * @param bool   $expectedBool
     * @param string $constName
     * @param string $expected
     *
     * @dataProvider prepareDataProvider
     */
    public function testGetConstValue(bool $expectedBool, string $constName, string $expected): void
    {
        self::$logger->info('parameters', [$expectedBool,$constName]);

        $actual = $this->o2t::publicGetConstValue($this->o2t->publicGetCastO2t(), $constName);

        self::$logger->debug('comparing', [$expected,$actual]);

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    public function testIsPrimitive(): void
    {
        $expected = true;
        $var = 100;

        $actual = $this->o2t::publicIsPrimitive($var);

        static::assertEquals($expected, $actual);
    }

    public function testGetAllDefinedConsts(): void
    {
        $expectedSize = 3;
        $clazz = get_class($this->o2t);

        $actual = $this->o2t::publicGetAllDefinedConsts($clazz);

        static::assertCount($expectedSize, $actual);
    }

    public function testGet_called_clazz(): void
    {
        $expected = get_class($this->o2t);

        $actual = $this->o2t::publicGet_called_clazz();

        static::assertEquals($expected, $actual);
    }

    public function testVerifyConstExists(): void
    {
        $constantName = get_class($this->o2t) . '::C_TEST';

        try {
            $this->o2t->publicVerifyConstExists($constantName);
        } catch (\Exception $exception) {
            static::fail('Should not raise an exception: ' . $exception->getMessage());
        }
    }

    public function testGet_called_function(): void
    {
        $expected = 'publicGet_called_function';

        $actual = $this->o2t->publicGet_called_function();

        static::assertEquals($expected, $actual);
    }

    // Data Provider

    /**
     * @return mixed[]
     */
    public function prepareDataProvider()
    {
        return [
            'public' => [ true, EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PUBLIC', 'public'],
            'protected' => [ true, EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PROTECTED', 'protected'],
            'private' => [ true, EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PRIVATE', 'private'],
            'notexist' => [ false, EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_NOTEXISTS', '']
        ];
    }
}
