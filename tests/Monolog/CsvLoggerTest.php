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

use Monolog\AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;
use Monolog\FileLoggerTest\FileLoggerTestTrait;
use Monolog\Handler\CsvHandler;
use PHPUnit\Framework\TestCase;

class CsvLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;
    use FileLoggerTestTrait;

    public const string TEST_MSG = 'Message';

    public const string TEST_CONTEXT_STRING = 'ContextString';

    /** @var array<string> */
    public const array TEST_CONTEXT_ARRAY = ['Context01', 'Context02'];

    protected CsvLogger $o2t;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t      = new CsvLogger(uniqid(self::class, true) . '-', sys_get_temp_dir());
        self::$fileName = $this->o2t->getFileName();
    }

    public function testConfiguration(): void
    {
        self::assertInstanceOf(CsvLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        self::assertNotEmpty($handlers);
        self::assertCount(1, $handlers);
        self::assertInstanceOf(CsvHandler::class, $handlers[0]);
    }

    public function testWriteHeader(): void
    {
        $expectedHeader = ['col1', 'col2', 'col3'];

        $csvLogger         = new CsvLogger('LoggerWithHeader', sys_get_temp_dir(), $expectedHeader);
        $csvLoggerFileName = $csvLogger->getFileName();

        if (file_exists($csvLoggerFileName)) {
            $csvLoggerContent = str_replace("\n", '', (string) file_get_contents($csvLoggerFileName));
            /**
             * @psalm-suppress ArgumentTypeCoercion
             * @phpstan-ignore argument.type
             */
            $actualHeader = explode($csvLogger->getItemSeparator(), $csvLoggerContent);
            unlink($csvLoggerFileName);
            self::assertEquals($expectedHeader, $actualHeader);
        } else {
            self::fail('File not created: ' . $csvLoggerFileName);
        }
    }

    public function testGetItemEnclosure(): void
    {
        $actual = $this->o2t->getItemEnclosure();
        self::assertEquals(CsvHandler::STANDARD_TEXT_SEP, $actual);
    }

    public function testGetItemSeparator(): void
    {
        $actual = $this->o2t->getItemSeparator();
        self::assertEquals(CsvHandler::STANDARD_ITEM_SEP, $actual);
    }

    public function testOutWithMessageOnly(): void
    {
        $message  = self::TEST_MSG;
        $expected = '/.*^' . self::TEST_MSG . '$.*/m';

        $this->o2t->out($message);

        $this->verifyFileContent($expected, self::$fileName);
    }

    public function testOutWithMessageAndContextString(): void
    {
        $message  = self::TEST_MSG;
        $context  = self::TEST_CONTEXT_STRING;
        $expected = '/.*^' . self::TEST_MSG . ';' . self::TEST_CONTEXT_STRING . '$.*/m';

        $this->o2t->out($message, $context);

        $this->verifyFileContent($expected, self::$fileName);
    }

    public function testOutWithMessageAndContextArray(): void
    {
        $message  = self::TEST_MSG;
        $context  = self::TEST_CONTEXT_ARRAY;
        $expected = '/.*^' . self::TEST_MSG . ';' . implode(';', self::TEST_CONTEXT_ARRAY) . '$.*/m';

        $this->o2t->out($message, $context);

        $this->verifyFileContent($expected, self::$fileName);
    }
}
