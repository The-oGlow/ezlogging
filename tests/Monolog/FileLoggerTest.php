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

require_once __DIR__ . '/../bootstrap.php';

use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\FileHandler;
use Monolog\Handler\HandlerInterface;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;
    use FileLoggerTestTrait;

    /** @var FileLogger */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t      = new FileLogger(uniqid(self::class, true), sys_get_temp_dir());
        self::$fileName = $this->o2t->getFileName();
        $this->silentIsExists = false;
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(FileLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        static::assertNotEmpty($handlers);
        static::assertCount(2, $handlers);
        static::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        static::assertInstanceOf(FileHandler::class, $handlers[1]);
    }

    public function testFileCreated(): void
    {
        static::assertNotEmpty(self::$fileName);
        static::assertFileDoesNotExist(self::$fileName);
        $this->o2t->info('Write a log entry');
        static::assertFileExists(self::$fileName);
    }

    public function testCreateWithCustomHandler(): void
    {
        $o2tB = new FileLogger(self::class, sys_get_temp_dir(), [new FileLoggerTestHandlerClazz()]);

        static::assertInstanceOf(FileLogger::class, $o2tB);
        $handlers = $o2tB->getHandlers();
        static::assertNotEmpty($handlers);
        static::assertCount(2, $handlers);
        static::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        static::assertInstanceOf(FileLoggerTestHandlerClazz::class, $handlers[1]);
    }

    public function testGetFileNameEmpty(): void
    {
        $o2tc = new FileLogger(self::class, sys_get_temp_dir(), [new FileLoggerTestHandlerClazz()]);
        static::assertInstanceOf(FileLogger::class, $o2tc);
        $fileName = $o2tc->getFileName();
        static::assertEmpty($fileName);
    }
}

/**
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols.
 */
class FileLoggerTestHandlerClazz implements HandlerInterface
{
    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function isHandling(array $record): bool
    {
        return true;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function handle(array $record): bool
    {
        return true;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function handleBatch(array $records): void
    {
        // nothing2do
    }

    public function close(): void
    {
        // nothing2do
    }
}
