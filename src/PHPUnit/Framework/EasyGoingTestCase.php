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

use Monolog\ConsoleLogger;
use Psr\Log\LoggerInterface;

abstract class EasyGoingTestCase extends TestCase
{
    /** var string Separator for static access */
    public const    C_STATIC_SEP = '::';

    /** @var string All primitive datatypes */
    protected const C_PRIMITIVES = 'int|integer|bool|boolean|float';

    /** @var mixed The object which will be tested. */
    protected $o2t;

    /**
     * @var bool TRUE=Execute a constants cross check (Default: FALSE)
     *
     * @see EasyGoingTestCase::expectedConstsCount
     */
    private static $withConstCrossCheck = false;

    /**
     * @var int Set the correct count of constants in child classes. Only used if {@link EasyGoingTestCase::crossCheckConsts}=true.
     *
     * @see EasyGoingTestCase::$withConstCrossCheck
     * @see EasyGoingTestCase::testAllConstants()
     */
    private static $expectedConstsCount = 0;

    /** @var mixed[] Array of the names of all constants in the class. */
    private static $actualConsts = [];

    /** @var LoggerInterface */
    private static $logger;

    /**
     * @param bool $withConstCrossCheck
     * @param int  $expectedConstsCount
     *
     * @see EasyGoingTestCase::$withConstCrossCheck
     * @see EasyGoingTestCase::$expectedConstsCount
     */
    public static function setUpBeforeClass(bool $withConstCrossCheck = false, int $expectedConstsCount = 0): void
    {
        self::$logger->debug('START');

        parent::setUpBeforeClass();
        self::$actualConsts        = [];
        self::$withConstCrossCheck = $withConstCrossCheck;
        self::$expectedConstsCount = $expectedConstsCount;
        self::$logger->notice('withConstCrossCheck,expectedConstCount', [self::$withConstCrossCheck, self::$expectedConstsCount]);

        self::$logger->debug('END');
    }

    public static function tearDownAfterClass(): void
    {
        self::$logger->debug('START');

        parent::tearDownAfterClass();
        self::crossCheckConstants(get_class(static::prepareO2t()), self::$actualConsts);
        self::$actualConsts        = [];
        self::$withConstCrossCheck = false;
        self::$expectedConstsCount = 0;

        self::$logger->debug('END');
    }

    /**
     * @return mixed
     */
    abstract protected static function prepareO2t();

    /**
     * @return mixed
     */
    abstract protected function getCasto2t();

    /**
     * @param mixed   $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        self::$logger = new ConsoleLogger(EasyGoingTestCase::class);
        self::$logger->debug('START');

        parent::__construct($name, $data, $dataName);

        self::$logger->debug('END');
    }

    public function setUp(): void
    {
        self::$logger->debug('START');

        parent::setUp();
        $this->o2t = static::prepareO2t();

        self::$logger->debug('END');
    }

    /**
     * @param mixed[] $constants
     */
    protected function verifyConstAllExists(array $constants = []): void
    {
        self::$logger->debug('START');

        foreach ($constants as $constant) {
            $this->verifyConstExists($constant);
        }

        self::$logger->debug('END');
    }

    /**
     * @param mixed[] $constants
     */
    protected function verifyConstArrayAllExists(array $constants = []): void
    {
        self::$logger->debug('START');

        foreach ($constants as $constant => $expectedSize) {
            $this->verifyConstExists($constant);
            $this->verifyConstArraySize($constant, $expectedSize);
        }

        self::$logger->debug('END');
    }

    protected function verifyConstArraySize(string $constantName, int $expectedSize): void
    {
        self::$logger->debug('START');

        $constantValue = self::getConstValue($this->o2t, $constantName);
        static::assertIsArray($constantValue);
        static::assertCount($expectedSize, $constantValue);

        self::$logger->debug('END');
    }

    /**
     * @param string $constantName
     *
     * @SuppressWarnings("PHPMD.ElseExpression")
     */
    protected function verifyConstExists(string $constantName): void
    {
        self::$logger->debug('START');

        $isDefined = self::isConstExist($this->o2t, $constantName);
        if ($isDefined) {
            $constantValue = self::getConstValue($this->o2t, $constantName);
            self::$logger->info("Checking '$constantName'=" . print_r($constantValue, true));
            if (static::isPrimitive($constantValue)) {
                static::assertGreaterThan(0, strlen("$constantValue"), "The primitive '$constantName'='$constantValue'");
            } else {
                static::assertNotEmpty($constantValue);
            }
        } else {
            static::fail(sprintf("FAIL: Constant '%s' not exists", $constantName));
        }

        self::$logger->debug('END');
    }

    /**
     * @param mixed $var
     *
     * @return bool
     */
    protected static function isPrimitive($var): bool
    {
        $primitive = false;

        if (isset($var) && strpos(self::C_PRIMITIVES, gettype($var)) > 0) {
            $primitive = true;
        }

        return $primitive;
    }

    /**
     * @param mixed $clazz
     *
     * @return mixed[]
     */
    protected static function getAllDefinedConsts($clazz): array
    {
        $clazz = new \ReflectionClass($clazz);

        return $clazz->getConstants(); // NOSONAR php:S3011
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return bool
     */
    protected static function isConstExist($clazz, string $constantName): bool
    {
        self::$logger->debug('START');

        try {
            $isDefined = defined($constantName);
            self::$logger->debug('Check existence by defined()', [$constantName]);
        } catch (\Throwable $e) {
            self::$logger->info('Cannot check existence by defined()', [$constantName]);
            $isDefined = false;
        }
        if (!$isDefined) {
            $allConsts  = self::getAllDefinedConsts($clazz);
            $splitClazz = explode(self::C_STATIC_SEP, $constantName);
            $isDefined  = isset($allConsts[$splitClazz[count($splitClazz) - 1]]);
            self::$logger->debug('Verify existence by reflection', [$constantName]);
        }

        self::$logger->debug('END');

        return $isDefined;
    }

    /**
     * @param mixed   $clazz
     * @param mixed[] $actualConsts
     *
     * @see EasyGoingTestCase::$withConstCrossCheck
     */
    protected static function crossCheckConstants($clazz, $actualConsts): void
    {
        self::$logger->debug('START');

        if (self::$withConstCrossCheck) {
            self::$logger->notice('CrossCheck is active');
            $expected = self::getAllDefinedConsts($clazz);
            ksort($expected);
            $expected = array_keys($expected);

            $callback = /**
             * @param mixed $value
             *
             * @return string
             */
                function ($value): string {
                    $res = '';
                    if (is_string($value) && str_contains($value, self::C_STATIC_SEP)) {
                        try {
                            $startPos = ((int)strpos($value, self::C_STATIC_SEP)) + strlen(self::C_STATIC_SEP);
                            $res      = substr($value, $startPos);
                        } catch (\Throwable $exception) {
                            self::$logger->error(sprintf("%s: '%s'", $exception->getMessage(), $value));
                        }
                    } else {
                        self::$logger->error(sprintf("Value has no '%s': '%s'", self::C_STATIC_SEP, $value));
                    }

                    return $res;
                };
            /** @var string[] */
            $actual = array_map($callback, $actualConsts);
            $actual = array_flip($actual);
            ksort($actual);
            $actual = array_keys($actual);
            static::assertEqualsCanonicalizing(
                $expected,
                $actual,
                'You have forgotten to check: ' . print_r(array_diff($expected, $actual), true)
            );
        }

        self::$logger->debug('END');
    }

    /**
     * @param null|mixed[] $checkedConsts
     *
     * @see EasyGoingTestCase::$withConstCrossCheck
     */
    protected static function updateActualConsts($checkedConsts): void
    {
        if (self::$withConstCrossCheck && !is_null($checkedConsts)) {
            self::$actualConsts = array_merge(self::$actualConsts, $checkedConsts);
        }
    }

    /**
     * @param int     $expectedCount
     * @param mixed[] $allDefinedConsts
     *
     * @return array<mixed>
     */
    protected static function checkConstantsCount(int $expectedCount, $allDefinedConsts)
    {
        self::$logger->debug('START');

        $allCount = sizeof($allDefinedConsts);
        if (self::$withConstCrossCheck) {
            $result = $expectedCount == $allCount;
        } else {
            $result = true;
        }

        self::$logger->debug('END');

        return [$result, $allCount];
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return mixed
     */
    protected static function getConstValue($clazz, string $constantName)
    {
        self::$logger->debug('START');

        try {
            $constantValue = constant($constantName);
            self::$logger->debug('Recieved by constant()', [$constantName]);
        } catch (\Throwable $e) {
            self::$logger->info('Cannot get value by constant()', [$constantName]);
        }
        if (!isset($constantValue)) {
            $clazz         = new \ReflectionClass($clazz);
            $splitClazz    = explode(self::C_STATIC_SEP, $constantName);
            $constantValue = $clazz->getConstant($splitClazz[count($splitClazz) - 1]); // NOSONAR php:S3011
            self::$logger->debug('Recieved by reflection', [$constantName]);
        }

        self::$logger->debug('END');

        return $constantValue;
    }

    public function testInit(): void
    {
        self::$logger->debug('START');

        static::assertNotEmpty($this->o2t);
        static::assertIsObject($this->o2t);
        static::assertInstanceOf(get_class($this->o2t), static::prepareO2t());

        self::$logger->debug('END');
    }

    /**
     * @see EasyGoingTestCase::$withConstCrossCheck
     * @see EasyGoingTestCase::$expectedConstsCount
     */
    public function testAllConstants(): void
    {
        self::$logger->debug('START');

        $allDefinedConsts = self::getAllDefinedConsts(get_class(static::prepareO2t()));
        ksort($allDefinedConsts);
        [$actual, $actualConstsCount] = self::checkConstantsCount(self::$expectedConstsCount, $allDefinedConsts);

        static::assertTrue(
            $actual,
            sprintf('Constants, expected count is not reached by actual count [%s, %s] ', self::$expectedConstsCount, $actualConstsCount)
        );

        self::$logger->debug('END');
    }
}
