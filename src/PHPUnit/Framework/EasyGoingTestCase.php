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
use PHPStan\BetterReflection\Reflection\ReflectionClass;
use PHPUnit\Framework\Error\Warning;

abstract class EasyGoingTestCase extends TestCase
{
    public const    C_STATIC_SEP = '::';

    protected const C_PRIMITIVES = 'int|integer|bool|boolean|float';

    /** @var \Monolog\Logger */
    protected $logger;

    /** @var mixed */
    protected $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->logger = new ConsoleLogger(static::class);
        $this->o2t    = $this->prepareO2t();
    }

    /**
     * @return mixed
     */
    abstract protected function prepareO2t();

    /**
     * @return mixed
     */
    abstract protected function getCasto2t();

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
            $this->logger->debug("Checking '$constantName'=" . print_r($constantValue, true));
            if (!static::isPrimitive($constantValue)) {
                static::assertNotEmpty($constantValue);
            } else {
                static::assertGreaterThan(0, strlen("$constantValue"), "The primitive '$constantName'='$constantValue'");
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

        return $clazz->getConstants();
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return bool
     */
    protected static function isConstExist($clazz, string $constantName): bool
    {
        $isDefined = defined($constantName);
        if (!$isDefined) {
            echo "\nisConstExist(): '$constantName' not public!";
            $allConsts  = self::getAllDefinedConsts($clazz);
            $splitClazz = explode(self::C_STATIC_SEP, $constantName);
            $isDefined  = isset($allConsts[$splitClazz[count($splitClazz) - 1]]);
        }

        return $isDefined;
    }

    /**
     * @param mixed   $clazz
     * @param mixed[] $actualConsts
     */
    public static function crossCheckConstants($clazz, array $actualConsts): void
    {
        $expected = self::getAllDefinedConsts($clazz);
        ksort($expected);
        $expected = array_keys($expected);

        $callback = /**
         * @param mixed $value
         *
         * @return string
         */
            function ($value): string {
                $startPos = ((int)strpos($value, self::C_STATIC_SEP)) + strlen(self::C_STATIC_SEP);

                return substr((string)$value, $startPos);
            };
        /** @var string[] */
        $actual = array_map($callback, $actualConsts);
        $actual = array_flip($actual);
        ksort($actual);
        $actual = array_keys($actual);

        //        print_r($expected);
        //        print_r($actual);
        static::assertEqualsCanonicalizing(
            $expected,
            $actual,
            'You have forgotten to check: ' . print_r(array_diff($expected, $actual), true)
        );
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
        } catch (Error $e) { // @phpstan-ignore catch.neverThrown
            echo "\ngetConstValue(): '" . $constantName . "' cannot get value!";
        }
        if (!isset($constantValue)) {
            $clazz         = new \ReflectionClass($clazz);
            $splitClazz    = explode(self::C_STATIC_SEP, $constantName);
            $constantValue = $clazz->getConstant($splitClazz[count($splitClazz) - 1]);
        }

        return $constantValue;
    }

    public function testInit(): void
    {
        static::assertNotEmpty($this->o2t);
        static::assertIsObject($this->o2t);
        static::assertInstanceOf(get_class($this->o2t), $this->prepareO2t());
    }
}
