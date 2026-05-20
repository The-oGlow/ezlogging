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

namespace Monolog\AbstractEasyGoingLoggerTest;

use DateTimeZone;
use Monolog\AbstractEasyGoingLogger;
use Monolog\Handler\ConsoleHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * This is the test clazz which will using the trait test-clazz.
 */
class AbstractEasyGoingLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;

    /** @var LoggerInterface */
    private static $logger;

    /** @var AbstractEasyGoingLoggerTestDummyClazz */
    protected $o2t;

    /**
     * @param mixed              $name
     * @param array<mixed,mixed> $data
     * @param string             $dataName
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
        $this->o2t = new AbstractEasyGoingLoggerTestDummyClazz(AbstractEasyGoingLoggerTest::class);

        self::$logger->debug('END');
    }

    public function testGetConsoleHandler(): void
    {
        $result = $this->callMethodOnO2t("getConsoleHandler");

        self::assertInstanceOf(ConsoleHandler::class, $result);
        self::assertInstanceOf(AbstractEasyGoingLoggerTestFormatterDummyClazz::class, $result->getFormatter());
    }

    public function testCreateWithDifferentTimezone(): void
    {
        $customDTZ = new DateTimeZone("America/Los_Angeles");
        $o2tb      = new AbstractEasyGoingLoggerTestDummyClazz(AbstractEasyGoingLoggerTest::class, AbstractEasyGoingLogger::LEVEL_DEFAULT, [], [], $customDTZ);

        self::assertInstanceOf(AbstractEasyGoingLoggerTestDummyClazz::class, $o2tb);
        self::assertEquals($customDTZ, $o2tb->getTimezone());
    }
}
