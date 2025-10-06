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

namespace Monolog\Handler;

use PHPUnit\Framework\TestCase;

class CsvHandlerTest extends TestCase
{
    /** @var CsvHandler */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new CsvHandler();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(CsvHandler::class, $this->o2t);
    }

    public function testGetFileNameDefault(): void
    {
        $result = $this->o2t->getFileName();

        static::assertNotEmpty($result);
        static::assertStringEndsWith(DIRECTORY_SEPARATOR . CsvHandler::STANDARD_FILENAME . CsvHandler::STANDARD_FILEEXT, $result);
    }

    public function testPrepareFileNameDefault(): void
    {
        $result = $this->o2t::prepareFileName();

        static::assertNotEmpty($result);
        static::assertStringEndsWith(DIRECTORY_SEPARATOR . CsvHandler::STANDARD_FILENAME . CsvHandler::STANDARD_FILEEXT, $result);
    }
}
