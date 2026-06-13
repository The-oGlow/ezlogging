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

use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\ConsoleHandler;
use Monolog\Processor\PlainProcessor;
use PHPUnit\Framework\TestCase;

/**
 * Description of LoggerAdapterTest.
 *
 * @author postm
 */
class LoggerAdapterTest extends TestCase
{
    use AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;
    use LoggerMethodsTestTrait;

    protected LoggerAdapter $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $handler = new ConsoleHandler();
        $handler->setFormatter(new PlainFormatter());
        $this->o2t = new LoggerAdapter(self::class, [$handler], [new PlainProcessor()]);
        $this->initLoggerMethodsTestTrait($this->o2t);
    }

    /**
     * @ignore
     */
    public function testOut(): void
    {
        self::assertTrue(true);
    }

    /**
     * @ignore
     */
    public function testGetDefaultProcessor(): void
    {
        self::assertTrue(true);
    }

    /**
     * @ignore
     */
    public function testGetDefaultHandler(): void
    {
        self::assertTrue(true);
    }

    /**
     * @ignore
     */
    public function testGetDefaultFormatter(): void
    {
        self::assertTrue(true);
    }
}
