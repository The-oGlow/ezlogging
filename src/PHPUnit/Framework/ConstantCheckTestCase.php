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

abstract class ConstantCheckTestCase extends EasyGoingTestCase
{
    /**
     * @var bool TRUE=Execute a constants cross check (Default: FALSE)
     *
     * @see ConstantCheckTestCase::expectedConstsCount
     */
    private static $withConstCrossCheck = false;

    /**
     * @var int Set the expected and correct count of constants in child classes. Only used if {@link ConstantCheckTestCase::$withConstCrossCheck}=true.
     *
     * @see ConstantCheckTestCase::$withConstCrossCheck
     * @see ConstantCheckTestCase::testAllConstants()
     */
    private static $expectedConstsCount = 0;

    /** @var mixed[] Array of the names of all constants in the class. */
    private static $actualConsts = [];

    /** @var LoggerInterface */
    private static $logger;

    /**
     * Inits the constants crosscheck.
     *
     * @param bool $withConstCrossCheck
     * @param int  $expectedConstsCount
     *
     * @see ConstantCheckTestCase::$withConstCrossCheck
     * @see ConstantCheckTestCase::$expectedConstsCount
     */
    public static function setUpBeforeClass(bool $withConstCrossCheck = false, int $expectedConstsCount = 0): void
    {
        self::$logger = new ConsoleLogger(ConstantCheckTestCase::class);
        self::$logger->debug('START');

        parent::setUpBeforeClass();
        $testInfo =  [self::$withConstCrossCheck, self::$expectedConstsCount, self::get_called_clazz()];
        self::$actualConsts        = [];
        self::$withConstCrossCheck = $withConstCrossCheck;
        self::$expectedConstsCount = $expectedConstsCount;
        self::$logger->notice('withConstCrossCheck,expectedConstCount,calledClazz', $testInfo);

        self::$logger->debug('END');
    }

    /**
     * Performs the constants crosscheck at the end.
     */
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

    // Static functions

    /**
     * @return bool TRUE=constant crosscheck is activated, else FALSE
     */
    public static function isWithConstCrossCheck(): bool
    {
        return self::$withConstCrossCheck;
    }

    /**
     * Executes the constant crosscheck  and fails if a constant is not found or not expected to exist.
     *
     * @param mixed   $clazz        the clazz having the constants to check
     * @param mixed[] $actualConsts an array of the already found constants
     *
     * @see ConstantCheckTestCase::$withConstCrossCheck
     */
    protected static function crossCheckConstants($clazz, $actualConsts): void
    {
        self::$logger->debug('START');

        if (self::$withConstCrossCheck) {
            self::$logger->notice('CrossCheck is active', [$clazz]);
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
     * Adds an array of constants which have been found.
     *
     * @param null|mixed[] $checkedConsts array of found constants
     *
     * @see ConstantCheckTestCase::$withConstCrossCheck
     */
    protected static function updateActualConsts($checkedConsts): void
    {
        if (self::$withConstCrossCheck && !is_null($checkedConsts)) {
            self::$actualConsts = array_merge(self::$actualConsts, $checkedConsts);
        }
    }

    /**
     * Checks, if {@link $allDefinedConsts) has the size of {@link $expectedCount}.
     *
     * @param int     $expectedCount    count of constants which must exists
     * @param mixed[] $allDefinedConsts an array with all defined constants
     *
     * @return array<mixed> [true|false, count($allDefinedConsts)]
     *
     * @see ConstantCheckTestCase::$withConstCrossCheck
     */
    protected static function checkConstantsCount(int $expectedCount, $allDefinedConsts)
    {
        self::$logger->debug('START');

        $allCount = count($allDefinedConsts);
        if (self::$withConstCrossCheck) {
            $result = $expectedCount == $allCount;
        } else {
            $result = true;
        }

        self::$logger->debug('END');

        return [$result, $allCount];
    }

    // Test functions

    /**
     * Checks, if the count of found constants matches to the exepected count of constants.
     *
     * @see ConstantCheckTestCase::$expectedConstsCount
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

    // Misc functions

    /**
     * Checks, if all constants exists.
     * <code>['CONST1','CONST2',...]</code>.
     *
     * @param mixed[] $constants an array with constants to check
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
     * Checks, if all constants exists are arrays and have the expected size.
     * <code>['CONST1'=>3,'CONST2'=>10,...]</code>.
     *
     * @param mixed[] $constants an array with constants and expected sizes to check
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

    /**
     * Checks, if a constant is an array and has the expected size.
     *
     * @param string $constantName Name of the constant
     * @param int    $expectedSize expected size of the constant
     */
    protected function verifyConstArraySize(string $constantName, int $expectedSize): void
    {
        self::$logger->debug('START');

        $constantValue = self::getConstValue($this->o2t, $constantName);
        static::assertIsArray($constantValue);
        static::assertCount($expectedSize, $constantValue);

        self::$logger->debug('END');
    }
}
