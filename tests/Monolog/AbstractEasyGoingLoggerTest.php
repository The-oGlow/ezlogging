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
use Monolog\Handler\ConsoleHandler;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AbstractEasyGoingLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;

    /** @var LoggerInterface */
    private static $logger;

    /** @var AbstractEasyGoingLoggerTestClazz */
    protected $o2t;

    /**
     * @param mixed   $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, $data = [], $dataName = '')
    {
        self::$logger = new Logger(AbstractEasyGoingLoggerTest::class);
        self::$logger->debug('START');
        parent::__construct($name, $data, $dataName);
        self::$logger->debug('END');
    }

    public function setUp(): void
    {
        self::$logger->debug('START');
        parent::setUp();
        $this->o2t = new AbstractEasyGoingLoggerTestClazz(AbstractEasyGoingLoggerTest::class);
        self::$logger->debug('END');
    }

    public function testGetConsoleHandler(): void
    {
        $result = $this->callMethodOnO2t("getConsoleHandler");

        static::assertInstanceOf(ConsoleHandler::class, $result);
        static::assertInstanceOf(AbstractEasyGoingLoggerTestFormatterClazz::class, $result->getFormatter());
    }

    public function testCreateWithDifferentTimezone(): void
    {
        $customDTZ = new DateTimeZone("America/Los_Angeles");
        $o2tb      = new AbstractEasyGoingLoggerTestClazz(AbstractEasyGoingLoggerTest::class, [], [], $customDTZ);

        static::assertInstanceOf(AbstractEasyGoingLoggerTestClazz::class, $o2tb);
        static::assertEquals($customDTZ, $o2tb->getTimezone());
    }
}
