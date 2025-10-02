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
    use TraitTestAbstractEasyGoingLogger;
    use TraitTestFileLogger;

    public const TEST_MSG = 'Message';

    public const TEST_CONTEXT_STRING = 'ContextString';

    public const TEST_CONTEXT_ARRAY = ['Context01', 'Context02'];

    /** @var CsvLogger */
    private $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t      = new CsvLogger(uniqid(self::class, true) . '-', sys_get_temp_dir());
        self::$fileName = $this->o2t->getFileName();
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

    public function testWriteHeader(): void
    {
        $expectedHeader = ['col1', 'col2', 'col3'];

        $csvLogger         = new CsvLogger('LoggerWithHeader', sys_get_temp_dir(), $expectedHeader);
        $csvLoggerFileName = $csvLogger->getFileName();

        if (file_exists($csvLoggerFileName)) {
            $csvLoggerContent = str_replace("\n", '', file_get_contents($csvLoggerFileName)); // @phpstan-ignore argument.type
            /** @psalm-suppress ArgumentTypeCoercion */
            $actualHeader = explode($csvLogger->getItemSeparator(), $csvLoggerContent);
            unlink($csvLoggerFileName);
            static::assertEquals($expectedHeader, $actualHeader);
        } else {
            static::fail('File not created: ' . $csvLoggerFileName);
        }
    }

    public function testGetItemEnclosure(): void
    {
        $actual = $this->o2t->getItemEnclosure();
        static::assertEquals(CsvHandler::STANDARD_TEXT_SEP, $actual);
    }

    public function testGetItemSeparator(): void
    {
        $actual = $this->o2t->getItemSeparator();
        static::assertEquals(CsvHandler::STANDARD_ITEM_SEP, $actual);
    }

    public function testOutWithMessageOnly(): void
    {
        $message  = self::TEST_MSG;
        $expected = '/.*^' . self::TEST_MSG . '$.*/m';

        $this->o2t->out($message);

        static::expectOutputRegex($expected);
    }

    public function testOutWithMessageAndContextString(): void
    {
        $message  = self::TEST_MSG;
        $context  = self::TEST_CONTEXT_STRING;
        $expected = '/.*^' . self::TEST_MSG . ';' . self::TEST_CONTEXT_STRING . '$.*/m';

        $this->o2t->out($message, $context);

        static::expectOutputRegex($expected);
    }

    public function testOutWithMessageAndContextArray(): void
    {
        $message  = self::TEST_MSG;
        $context  = self::TEST_CONTEXT_ARRAY;
        $expected = '/.*^' . self::TEST_MSG . ';' . implode(';', self::TEST_CONTEXT_ARRAY) . '$.*/m';

        $this->o2t->out($message, $context);

        static::expectOutputRegex($expected);
    }
}
