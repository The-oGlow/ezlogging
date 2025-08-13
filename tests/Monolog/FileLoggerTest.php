<?php

use Monolog\FileLogger;
use Monolog\Handler\StreamHandler;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase
{
    use UnavailableFieldsTrait;

    private $o2t;
    private $fileName;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new FileLogger(self::class, sys_get_temp_dir());
        $this->fileName = sys_get_temp_dir(). DIRECTORY_SEPARATOR . self::class. $this->o2t::STANDARD_FILEEXT;
    }

    public function testConfiguration()
    {
        $this::assertInstanceOf(FileLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        $this::assertIsArray($handlers);
        $this::assertCount(2, $handlers);
        $this::assertInstanceOf(StreamHandler::class, $handlers[0]);
        $this::assertInstanceOf(StreamHandler::class, $handlers[1]);
    }


    public function testFileCreated()
    {
        $this::assertFileDoesNotExist($this->fileName);
        $this->o2t->info('Write a log entry');
        $this->assertFileExists($this->fileName);
    }

    public function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
        parent::tearDown();
    }
}
