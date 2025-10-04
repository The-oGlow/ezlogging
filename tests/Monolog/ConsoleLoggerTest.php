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

namespace Monolog;

use DateTimeZone;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class ConsoleLoggerTest.
 */
class ConsoleLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;

    /** @var ConsoleLogger */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ConsoleLogger(self::class);
    }

    public function testCreateWithDifferentTimezone(): void
    {
        $customDTZ = new DateTimeZone("America/Los_Angeles");
        $o2tb      = new ConsoleLogger(self::class, [], [], $customDTZ);

        static::assertInstanceOf(ConsoleLogger::class, $o2tb);
        static::assertEquals($customDTZ, $o2tb->getTimezone());
    }
}
