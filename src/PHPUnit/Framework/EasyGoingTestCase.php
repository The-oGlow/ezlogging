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
    public const    C_STATIC_SEP = '::';

    protected const C_PRIMITIVES = 'int|integer|bool|boolean|float';

    /** @var mixed The object which will be tested. */
    protected $o2t;

    /**
     * @var bool TRUE=Execute a constants cross check (Default: FALSE)
     *
     * @see EasyGoingTestCase::expectedConstsCount
     */
    private static $crossCheckConsts = false;

    /**
     * @var int Set the correct count of constants in child classes. Only used if {@link EasyGoingTestCase::crossCheckConsts}=true.
     *
     * @see EasyGoingTestCase::crossCheckConsts
     * @see EasyGoingTestCase::testAllConstants()
     */
    private $expectedConstsCount = 0;

    /** @var mixed[] Array of the names of all constants in the class. */
    private static $actualConsts = [];

    /** @var LoggerInterface */
    private static $logger;

    /**
     * @see EasyGoingTestCase::crossCheckConsts
     */
    public static function setUpBeforeClass(): void
    {
        self::$logger->debug('START');
        parent::setUpBeforeClass();
        self::$actualConsts = [];
        self::$logger->debug('END');
    }

    public static function tearDownAfterClass(): void
    {
        self::$logger->debug('START');
        parent::tearDownAfterClass();
        self::crossCheckConstants(get_class(static::prepareO2t()), self::$actualConsts);
        self::$actualConsts     = [];
        self::$crossCheckConsts = false;
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

    protected function getExpectedConstsCount(): int
    {
        return 0;
    }

    protected function isConstsCrosscheck(): bool
    {
        return false;
    }

    public function setUp(): void
    {
        self::$logger->debug('START');
        parent::setUp();
        self::$crossCheckConsts    = $this->isConstsCrosscheck();
        $this->expectedConstsCount = $this->getExpectedConstsCount();
        self::$logger->info('crossCheckConsts,expectedConstCount', [self::$crossCheckConsts, $this->expectedConstsCount]);
        $this->o2t                 = static::prepareO2t();
        self::$logger->debug('END');
    }

    /**
     * @param mixed[] $constants
     */
    protected function verifyConstAllExists(array $constants = []): void
    {
        foreach ($constants as $constant) {
            $this->verifyConstExists($constant);
        }
    }

    /**
     * @param mixed[] $constants
     */
    protected function verifyConstArrayAllExists(array $constants = []): void
    {
        foreach ($constants as $constant => $expectedSize) {
            $this->verifyConstExists($constant);
            $this->verifyConstArraySize($constant, $expectedSize);
        }
    }

    protected function verifyConstArraySize(string $constantName, int $expectedSize): void
    {
        $constantValue = self::getConstValue($this->o2t, $constantName);
        static::assertIsArray($constantValue);
        static::assertCount($expectedSize, $constantValue);
    }

    /**
     * @param string $constantName
     *
     * @SuppressWarnings("PHPMD.ElseExpression")
     */
    protected function verifyConstExists(string $constantName): void
    {
        $isDefined = self::isConstExist($this->o2t, $constantName);
        if ($isDefined) {
            $constantValue = self::getConstValue($this->o2t, $constantName);
            self::$logger->debug("Checking '$constantName'=" . print_r($constantValue, true));
            if (static::isPrimitive($constantValue)) {
                static::assertGreaterThan(0, strlen("$constantValue"), "The primitive '$constantName'='$constantValue'");
            } else {
                static::assertNotEmpty($constantValue);
            }
        } else {
            static::fail(sprintf("FAIL: Constant '%s' not exists", $constantName));
        }
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
        try {
            $isDefined = defined($constantName);
            self::$logger->debug('Check existence by defined()', [$constantName]);
        } catch (\Throwable $e) {
            self::$logger->debug('Cannot check existence by defined()', [$constantName]);
            $isDefined = false;
        }
        if (!$isDefined) {
            $allConsts  = self::getAllDefinedConsts($clazz);
            $splitClazz = explode(self::C_STATIC_SEP, $constantName);
            $isDefined  = isset($allConsts[$splitClazz[count($splitClazz) - 1]]);
            self::$logger->debug('Verify existence by reflection', [$constantName]);
        }

        return $isDefined;
    }

    /**
     * @param mixed   $clazz
     * @param mixed[] $actualConsts
     *
     * @see EasyGoingTestCase::crossCheckConsts
     */
    protected static function crossCheckConstants($clazz, $actualConsts): void
    {
        if (self::$crossCheckConsts) {
            self::$logger->info('Cross check is active');
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
    }

    /**
     * @param null|mixed[] $checkedConstants
     *
     * @see EasyGoingTestCase::crossCheckConsts
     */
    protected static function updateActualConsts($checkedConstants): void
    {
        if (self::$crossCheckConsts && !is_null($checkedConstants)) {
            self::$actualConsts = array_merge(self::$actualConsts, $checkedConstants);
        }
    }

    /**
     * @param int     $expectedConstantsCount
     * @param mixed[] $allDefinedConsts
     *
     * @return array<mixed>
     */
    protected static function checkConstantsCount(int $expectedConstantsCount, $allDefinedConsts)
    {
        $actualConstantCount = sizeof($allDefinedConsts);
        if (self::$crossCheckConsts) {
            $result = $expectedConstantsCount == $actualConstantCount;
        } else {
            $result = true;
        }

        return [$result,$actualConstantCount];
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return mixed
     */
    protected static function getConstValue($clazz, string $constantName)
    {
        try {
            $constantValue = constant($constantName);
            self::$logger->debug('Recieved by constant()', [$constantName]);
        } catch (\Throwable $e) {
            self::$logger->debug('Cannot get value by constant()', [$constantName]);
        }
        if (!isset($constantValue)) {
            $clazz         = new \ReflectionClass($clazz);
            $splitClazz    = explode(self::C_STATIC_SEP, $constantName);
            $constantValue = $clazz->getConstant($splitClazz[count($splitClazz) - 1]); // NOSONAR php:S3011
            self::$logger->debug('Recieved by reflection', [$constantName]);
        }

        return $constantValue;
    }

    public function testInit(): void
    {
        static::assertNotEmpty($this->o2t);
        static::assertIsObject($this->o2t);
        static::assertInstanceOf(get_class($this->o2t), static::prepareO2t());
    }

    /**
     * @see EasyGoingTestCase::crossCheckConsts
     * @see EasyGoingTestCase::expectedConstsCount
     */
    public function testAllConstants(): void
    {
        $allDefinedConsts = self::getAllDefinedConsts(get_class(static::prepareO2t()));
        ksort($allDefinedConsts);
        [$actual,$actualConstsCount] = self::checkConstantsCount($this->expectedConstsCount, $allDefinedConsts);

        static::assertTrue($actual, sprintf('Constants, expected count is not reached by actual count [%s, %s] ', $this->expectedConstsCount, $actualConstsCount));
    }
}
