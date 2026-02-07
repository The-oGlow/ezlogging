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
 * @see EasyGoingTestCaseTestCaseClazz
 */
class EasyGoingTestCaseTest extends TestCase
{
    use UnavailableMethodsTrait;
    use UnavailableFieldsTrait;

    /** @var EasyGoingTestCaseTestCaseClazz */
    protected $o2t;

    /** @var LoggerInterface */
    private static $logger;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        // function must be called manually
        $sO2t = self::prepareO2t();
        $sO2t::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        // function must be called manually
        $sO2t = self::prepareO2t();
        $sO2t::tearDownAfterClass();
    }

    /**
     * @return EasyGoingTestCaseTestCaseClazz
     */
    protected static function prepareO2t()
    {
        return new EasyGoingTestCaseTestCaseClazz();
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

    public function testPrepareO2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual   = $this->callMethodOnO2t('prepareO2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseClazz::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseClazz::class, $actual);
        static::assertNotSame($expected, $actual);
        static::assertEquals($expected, $actual);
    }

    public function testGetCasto2t(): void
    {
        $expected = $this->getFieldFromO2t("o2t");
        $actual   = $this->callMethodOnO2t('getCasto2t');

        static::assertNotEmpty($expected);
        static::assertNotEmpty($actual);
        static::assertInstanceOf(EasyGoingTestCaseClazz::class, $expected);
        static::assertInstanceOf(EasyGoingTestCaseClazz::class, $actual);
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

    public function testTestAllConstants(): void
    {
        try {
            $this->o2t->testAllConstants();
        } catch (\Exception $e) {
            static::fail('Should not raise any exection: ' . $e->getMessage());
        }
    }

    public function testTestConsts(): void
    {
        try {
            $this->o2t->testConsts();
        } catch (\Exception $e) {
            static::fail('Should not raise any exection: ' . $e->getMessage());
        }
    }

    /**
     * @param string $expected
     * @param bool   $expectedBool
     * @param string $constName
     *
     * @dataProvider prepareDataProvider
     */
    public function testGetConstValue(string $expected, bool $expectedBool, string $constName): void
    {
        self::$logger->info('parameters', [$expected,$expectedBool,$constName]);

        $actual = $this->o2t::publicGetConstValue($this->o2t->publicGetCastO2t(), $constName);

        self::$logger->debug('comparing', [$expected,$actual]);

        static::assertEquals($expected, $actual, "Not equals: '$expected'='$actual'");
    }

    /**
     * @param string $expected
     * @param bool   $expectedBool
     * @param string $constName
     *
     * @dataProvider prepareDataProvider
     */
    public function testIsConstExist(string $expected, bool $expectedBool, string $constName): void
    {
        self::$logger->info('parameters', [$expected,$expectedBool,$constName]);

        $actual = $this->o2t::publicIsConstExist($this->o2t->publicGetCastO2t(), $constName);

        self::$logger->debug('comparing', [$expectedBool,$actual]);

        static::assertEquals($expectedBool, $actual, "Not equals: '$expectedBool'='$actual'");
    }

    /**
     * @return mixed[]
     */
    public function prepareDataProvider()
    {
        return [
            ['public', true, EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PUBLIC'],
            ['protected', true, EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PROTECTED'],
            ['private', true, EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PRIVATE'],
            ['none', true, EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_NONE'],
            ['', false, EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_NOTEXISTS']
        ];
    }
}
