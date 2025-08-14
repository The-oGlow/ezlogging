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

class FileHandlerTest extends TestCase
{
    /** @var FileHandler $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new FileHandler();
    }

    public function testConfiguration(): void
    {
        $this::assertInstanceOf(FileHandler::class, $this->o2t);
    }

    public function testGetFileNameDefault(): void
    {
        $result = $this->o2t->getFileName();

        $this::assertNotEmpty($result);
        $this::assertStringEndsWith(DIRECTORY_SEPARATOR. FileHandler::STANDARD_FILENAME.FileHandler::STANDARD_FILEEXT, $result);
    }

    public function testPrepareFileNameDefault(): void
    {
        $result = $this->o2t::prepareFileName();

        $this::assertNotEmpty($result);
        $this::assertStringEndsWith(DIRECTORY_SEPARATOR. FileHandler::STANDARD_FILENAME.FileHandler::STANDARD_FILEEXT, $result);
    }

    public function testPrepareFileNameWithFileName(): void
    {
        $fileName = "XXX";

        $result = $this->o2t::prepareFileName(null, $fileName);

        $this::assertNotEmpty($result);
        $this::assertStringEndsWith(DIRECTORY_SEPARATOR. $fileName.FileHandler::STANDARD_FILEEXT, $result);
    }

    public function testPrepareFileNameWithPath(): void
    {
        $pathToFile = "YYYFOLDER";

        $result = $this->o2t::prepareFileName($pathToFile);

        $this::assertNotEmpty($result);
        $this::assertStringEndsWith($pathToFile.DIRECTORY_SEPARATOR. FileHandler::STANDARD_FILENAME. FileHandler::STANDARD_FILEEXT, $result);
    }

    public function testPrepareFileNameWithPathAndFileName(): void
    {
        $pathToFile = "YYYFOLDER";
        $fileName = "XXX";

        $result = $this->o2t::prepareFileName($pathToFile, $fileName);

        $this::assertNotEmpty($result);
        $this::assertStringEndsWith($pathToFile.DIRECTORY_SEPARATOR. $fileName. FileHandler::STANDARD_FILEEXT, $result);
    }

}
