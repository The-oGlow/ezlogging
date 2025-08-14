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

use Monolog\FileLogger;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\FileHandler;
use Monolog\Handler\StreamHandler;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase
{
    use UnavailableFieldsTrait;

    /** @var FileLogger $o2t */
    private $o2t;
    /** @var string $fileName */
    private $fileName;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new FileLogger(self::class, sys_get_temp_dir());
        $this->fileName = $this->o2t->getFileName();
    }

    public function testConfiguration(): void
    {
        $this::assertInstanceOf(FileLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        $this::assertNotEmpty($handlers);
        $this::assertCount(2, $handlers);
        $this::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        $this::assertInstanceOf(FileHandler::class, $handlers[1]);
    }

    public function testFileCreated(): void
    {
        $this::assertNotEmpty($this->fileName);
        $this::assertFileDoesNotExist($this->fileName);
        $this->o2t->info('Write a log entry');
        $this->assertFileExists($this->fileName);
    }

    public function testCreateWithHandler(): void
    {
        $o2tB = new FileLogger(self::class, sys_get_temp_dir(), [new ConsoleHandler()]);

        $this::assertInstanceOf(FileLogger::class, $o2tB);
        $handlers = $o2tB->getHandlers();
        $this::assertNotEmpty($handlers);
        $this::assertCount(2, $handlers);
        $this::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        $this::assertInstanceOf(ConsoleHandler::class, $handlers[1]);
    }

    public function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
        parent::tearDown();
    }
}
