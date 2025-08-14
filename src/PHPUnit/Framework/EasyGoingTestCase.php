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
        $this->logger = new ConsoleLogger(static::class);
        $this->o2t    = $this->prepareO2t();
    }

    abstract protected function prepareO2t(): mixed;

    abstract protected function getCasto2t(): mixed;

    /** @param mixed[] $constants */
    protected function verifyConstAllExists(array $constants = []): void
    {
        foreach ($constants as $constant) {
            $this->verifyConstExists($constant);
        }
    }

    /** @param mixed[] $constants */
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
        $this::assertIsArray($constantValue);
        $this::assertCount($expectedSize, $constantValue);
    }

    protected function verifyConstExists(string $constantName): void
    {
        if (defined($constantName)) {
            $constantValue = constant($constantName);
            $this->logger->debug("Checking '$constantName'=" . var_export($constantValue, true));
            if (!self::is_primitive($constantValue)) {
                $this->assertNotEmpty($constantValue);
            }
        } else {
            $this->fail(sprintf("FAIL: Constant '%s' not exists", $constantName));
        }
    }

    public const LOP = 'int|integer|bool|boolean|float';

    protected static function is_primitive(mixed $var): bool
    {
        $primitive = false;
        if (isset($var) && strpos(self::LOP, gettype($var)) > 0) {
            $primitive = true;
        }

        return $primitive;
    }

    public function testInit(): void
    {
        $this::assertNotEmpty($this->o2t);
        $this::assertInstanceOf($this->o2t, get_class($this->prepareO2t()));
    }
}
