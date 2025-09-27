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

use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\CsvHandler;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class CsvLoggerTest extends TestCase
{
    use TraitForAbstractEasyGoingLogger;

    /** @var CsvLogger */
    private $o2t;

    /** @var string */
    private $fileName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new CsvLogger(self::class, sys_get_temp_dir());
        $this->fileName = $this->o2t->getFileName();
    }

    public function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            echo "\n\nContent of '$this->fileName'\n";
            echo file_get_contents($this->fileName);
            echo "\n";
            unlink($this->fileName);
        }
        parent::tearDown();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(CsvLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        static::assertNotEmpty($handlers);
        static::assertCount(2, $handlers);
        static::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        static::assertInstanceOf(CsvHandler::class, $handlers[1]);
    }

    public function testFileCreated(): void
    {
        static::assertNotEmpty($this->fileName);
        static::assertFileDoesNotExist($this->fileName);
        $this->o2t->info('Write a csv line');
        static::assertFileExists($this->fileName);
    }
}
