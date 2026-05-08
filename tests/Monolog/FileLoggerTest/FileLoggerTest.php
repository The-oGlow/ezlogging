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

namespace Monolog\FileLoggerTest;

use Monolog\AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;
use Monolog\FileLogger;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\FileHandler;
use PHPUnit\Framework\TestCase;

/**
 * This is the test clazz which will using the trait test-clazz.
 */
class FileLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;
    use FileLoggerTestTrait;

    /** @var FileLogger */
    protected $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t      = new FileLogger(uniqid(self::class, true), sys_get_temp_dir());
        self::$fileName = $this->o2t->getFileName();
        $this->silentIsExists = false;
    }

    public function testConfiguration(): void
    {
        $expectedCount = 2;
        self::assertInstanceOf(FileLogger::class, $this->o2t);

        $handlers = $this->o2t->getHandlers();

        self::assertNotEmpty($handlers, var_export($handlers, true));
        self::assertCount($expectedCount, $handlers, var_export($handlers, true));
        self::assertInstanceOf(ConsoleHandler::class, $handlers[0], var_export($handlers, true));
        self::assertInstanceOf(FileHandler::class, $handlers[1], var_export($handlers, true));
    }

    public function testFileCreated(): void
    {
        self::assertNotEmpty(self::$fileName);
        self::assertFileDoesNotExist(self::$fileName);

        $this->o2t->info('Write a log entry');

        self::assertFileExists(self::$fileName);
    }

    public function testCreateWithCustomHandler(): void
    {
        $expectedCount = 3;

        $o2tB = new FileLogger(uniqid(self::class, true), sys_get_temp_dir(), [new FileLoggerTestHandlerDummyClazz()]);
        self::assertInstanceOf(FileLogger::class, $o2tB);

        $handlers = $o2tB->getHandlers();

        self::assertNotEmpty($handlers, var_export($handlers, true));
        self::assertCount($expectedCount, $handlers, var_export($handlers, true));
        self::assertInstanceOf(ConsoleHandler::class, $handlers[0], var_export($handlers, true));
        self::assertInstanceOf(FileHandler::class, $handlers[1], var_export($handlers, true));
        self::assertInstanceOf(FileLoggerTestHandlerDummyClazz::class, $handlers[2], var_export($handlers, true));
    }

    public function testGetFileNameEmpty(): void
    {
        $targetFolder = sys_get_temp_dir();
        $targetFilename = str_replace(FileHandler::C_NS_SEP, FileHandler::C_NS_FS_SEP, uniqid(self::class, true));

        $o2tc = new FileLogger($targetFilename, $targetFolder, [new FileLoggerTestHandlerDummyClazz()]);
        self::assertInstanceOf(FileLogger::class, $o2tc);

        $fileName = $o2tc->getFileName();

        self::assertNotEmpty($fileName, $fileName);
        self::assertStringContainsString($targetFolder, $fileName, $fileName);
        self::assertStringContainsString($targetFilename, $fileName, $fileName);
    }
}
