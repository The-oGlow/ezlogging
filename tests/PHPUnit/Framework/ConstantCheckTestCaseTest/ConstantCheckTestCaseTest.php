<?php
/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 29.04.2026
 * Time: 11:47
 */

namespace PHPUnit\Framework\ConstantCheckTestCaseTest;

use Monolog\ConsoleLogger;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\ConstantCheckTestCase;
use PHPUnit\Framework\EasyGoingTestCaseTest\EasyGoingTestCaseTest;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * This is the test clazz which will test the test clazz.
 *
 * @see ConstantCheckTestCaseClazz
 */

class ConstantCheckTestCaseTest extends TestCase
{

    use UnavailableMethodsTrait;
    use UnavailableFieldsTrait;

    private const TEST_CONST_PREFIX_NAME = 'TEST_CONST_PREFIX';

    private const TEST_CONST_ARRAY_NAME = 'TEST_CONST_ARRAY';

    private const TEST_CONST_ARRAY_SIZE = 2;

    private const WRONG_CONST           = 'WRONG_CONST';

    private const WRONG_CONST_SIZE = 1;

    /** @var ConstantCheckTestCaseClazz */
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
     * @return ConstantCheckTestCaseClazz
     */
    protected static function prepareO2t()
    {
        return new ConstantCheckTestCaseClazz();
    }

    /**
     * @return mixed[]
     */
    protected static function prepareAllConsts(): array
    {
        return ConstantCheckTestCaseClazz::prepareAllConsts();
    }

    /**
     * @param mixed   $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        self::$logger = new ConsoleLogger(ConstantCheckTestCaseTest::class);
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

    public function ztestSetUpBeforeClass(): void
    {
        $sO2t      = static::prepareO2t();
        $clazzName = ConstantCheckTestCase::class;

        $sO2t::setUpBeforeClass();

        $locActualConsts = self::getFieldByReflection($clazzName, 'actualConsts', null);
        static::assertEmpty($locActualConsts);
        $locWithConstCrossCheck = self::getFieldByReflection($clazzName, 'withConstCrossCheck', null);
        static::assertFalse($locWithConstCrossCheck);
        $locExpectedConstsCount = self::getFieldByReflection($clazzName, 'expectedConstsCount', null);
        static::assertEmpty($locExpectedConstsCount);
    }

    public function ztestTearDownAfterClass(): void
    {
        $sO2t      = static::prepareO2t();
        $clazzName = ConstantCheckTestCase::class;

        $sO2t::tearDownAfterClass();

        $locActualConsts = self::getFieldByReflection($clazzName, 'actualConsts', null);
        static::assertEmpty($locActualConsts);
        $locWithConstCrossCheck = self::getFieldByReflection($clazzName, 'withConstCrossCheck', null);
        static::assertFalse($locWithConstCrossCheck);
        $locExpectedConstsCount = self::getFieldByReflection($clazzName, 'expectedConstsCount', null);
        static::assertEmpty($locExpectedConstsCount);
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
     * @param string  $expected
     * @param bool    $success
     * @param mixed[] $constants
     *
     * @dataProvider prepareConstantsDataProvider
     */
    public function testVerifyConstAllExists(string $expected, bool $success, array $constants): void
    {
        self::$logger->info('parameters', [$expected, $success, $constants]);
        $exception = null;

        try {
            $this->o2t->publicVerifyConstAllExists($constants);
        } catch (\Exception $exception) {
            // Catch the exception
        }
        $this->verifyConstantsTestResult($success, $exception, [$expected, $success, $constants]);
    }

    /**
     * @param string  $expected
     * @param bool    $success
     * @param mixed[] $constants
     *
     * @dataProvider prepareConstantsArrayDataProvider
     */
    public function testVerifyConstArrayAllExists(string $expected, bool $success, array $constants): void
    {
        self::$logger->info('parameters', [$expected, $success, $constants]);
        $exception = null;

        try {
            $this->o2t->publicVerifyConstArrayAllExists($constants);
        } catch (\Exception $exception) {
            // Catch the exception
        }
        $this->verifyConstantsTestResult($success, $exception, [$expected, $success, $constants]);
    }

    /**
     * @param string $expected
     * @param bool   $success
     * @param string $constantName
     * @param int    $expectedSize
     *
     * @dataProvider prepareConstantNameDataProvider
     */
    public function testVerifyConstArraySize(string $expected, bool $success, string $constantName, int $expectedSize): void
    {
        self::$logger->info('parameters', [$expected, $constantName, $expectedSize]);
        $exception = null;

        try {
            $this->o2t->publicVerifyConstArraySize($constantName, $expectedSize);
        } catch (\Exception $exception) {
            // Catch the exception
        }
        $this->verifyConstantsTestResult($success, $exception, [$expected, $success, $constantName, $expectedSize]);
    }

    /**
     * @param string  $expected
     * @param bool    $success
     * @param bool    $crossCheckActive
     * @param string  $clazz
     * @param mixed[] $actualConstants
     *
     * @dataProvider prepareCrossCheckDataProvider
     */
    public function testCrossCheckConstants(string $expected, bool $success, bool $crossCheckActive, string $clazz, array $actualConstants): void
    {
        self::$logger->info('parameters', [$expected, $success, $crossCheckActive, $clazz, $actualConstants]);

        $ccO2t = self::prepareO2t();
        self::setFieldByReflection(get_parent_class($ccO2t), 'withConstCrossCheck', $ccO2t, $crossCheckActive);
        $ccO2t::publicUpdateActualConsts($actualConstants);

        $exception = null;

        try {
            $ccO2t->publicCrossCheckConstants($clazz, $actualConstants);
        } catch (\Exception $exception) {
            // Catch the exception
        }
        $ccO2t::tearDownAfterClass();
        $this->verifyConstantsTestResult($success, $exception, [$expected, $success, $crossCheckActive, $clazz, $actualConstants]);
    }

    // Data Provider

    /**
     * @return mixed[]
     */
    public function prepareConstantsDataProvider()
    {
        return [
            ['emptyList', true, []],
            ['wrongConst', false, [self::WRONG_CONST]],
            ['existConstOne', true, [self::TEST_CONST_PREFIX_NAME]],
            ['existConstAll', true, self::prepareAllConsts()],
        ];
    }

    /**
     * @return mixed[]
     */
    public function prepareConstantsArrayDataProvider()
    {
        return [
            ['emptyList', true, []],
            ['wrongConst', false, [self::WRONG_CONST => self::TEST_CONST_ARRAY_SIZE]],
            ['wrongSize', false, [self::TEST_CONST_ARRAY_NAME => self::WRONG_CONST_SIZE]],
            ['allCorrect', true, [self::TEST_CONST_ARRAY_NAME => self::TEST_CONST_ARRAY_SIZE]],
        ];
    }

    /**
     * @return mixed[]
     */
    public function prepareConstantNameDataProvider()
    {
        return [
            ['missingName', false, '', self::TEST_CONST_ARRAY_SIZE],
            ['wrongConst', false, self::WRONG_CONST, self::TEST_CONST_ARRAY_SIZE],
            ['wrongSize', false, self::TEST_CONST_ARRAY_NAME, self::WRONG_CONST_SIZE],
            ['allCorrect', true, self::TEST_CONST_ARRAY_NAME, self::TEST_CONST_ARRAY_SIZE],
        ];
    }

    /**
     * @return mixed[]
     */
    public function prepareCrossCheckDataProvider()
    {
        return [
            ['emptyListDisabled', true, false, ConstantCheckTestCaseDummyClazz::class, []],
            ['emptyListEnabled', false, true, ConstantCheckTestCaseDummyClazz::class, []],
            [
                'wrongConstEnabled',
                false,
                true,
                ConstantCheckTestCaseDummyClazz::class,
                array_merge(self::prepareAllConsts(), [ConstantCheckTestCaseDummyClazz::TEST_CLAZZ . self::WRONG_CONST])
            ],
            ['existConstOneEnabled', false, true, ConstantCheckTestCaseDummyClazz::class, [ConstantCheckTestCaseDummyClazz::TEST_CLAZZ . self::TEST_CONST_PREFIX_NAME]],
            ['existConstAllEnabled', true, true, ConstantCheckTestCaseDummyClazz::class, self::prepareAllConsts()],
        ];
    }

    // Misc functions

    /**
     * @param bool            $success
     * @param null|\Exception $exception
     * @param mixed[]         $extraData
     */
    protected function verifyConstantsTestResult(bool $success, ?\Exception $exception, array $extraData): void
    {
        if ($success) {
            if (empty($exception)) {
                self::$logger->info('Testcase ended correctly.', $extraData);
            } else {
                static::fail('Should raise no exception');
            }
        } else {
            if (!empty($exception)) {
                self::$logger->info('Testcase ended correctly with an exception.', $extraData);
            } else {
                static::fail('Should raise an exception');
            }
        }
        static::assertTrue(true);
    }
}