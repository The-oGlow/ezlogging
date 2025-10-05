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

abstract class EasyGoingTestCase extends TestCase
{
    /** @var \Monolog\Logger */
    protected $logger;

    /** @var mixed */
    protected $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->logger = new ConsoleLogger(self::class);
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
        $constantValue = constant($constantName);
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
        if (defined($constantName)) {
            $constantValue = constant($constantName);
            $this->logger->debug("Checking '$constantName'=" . print_r($constantValue, true));
            if (!static::isPrimitive($constantValue)) {
                static::assertNotEmpty($constantValue);
            }
        } else {
            static::fail(sprintf("FAIL: Constant '%s' not exists", $constantName));
        }
    }

    public const LOP = 'int|integer|bool|boolean|float';

    /**
     * @param mixed $var
     *
     * @return bool
     */
    protected static function isPrimitive($var): bool
    {
        $primitive = false;
        if (isset($var) && strpos(self::LOP, gettype($var)) > 0) {
            $primitive = true;
        }

        return $primitive;
    }

    public function testInit(): void
    {
        static::assertNotEmpty($this->o2t);
        static::assertIsObject($this->o2t);
        static::assertInstanceOf(get_class($this->o2t), $this->prepareO2t());
    }
}
