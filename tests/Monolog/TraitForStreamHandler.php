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

use Monolog\Test\TestCase as tCase;

/**
 * Trait TraitForStreamHandler
 *
 * @phpstan-ignore staticMethod.alreadyNarrowedType,method.notFound
 */
trait TraitForStreamHandler
{
    /** @var string  */
    private  $MESSAGE_1       = '-message 1';

    /** @var string  */
    private $MESSAGE_2       = 'message 2';

    /** @var string  */
    private $MESSAGE_3       = 'message 3';

    /** @var array<mixed,mixed>  */
    private $COMPLEX_CONTEXT = ['id1' => 'val1', 'id2' => 'val2', 3 => 3, 4 => [40, 41, ['idx400' => 'sub400', 'sub 401']]];

    /** @var string  */
    private $methodName      = 'out';

    /** @var string */
    private static $fileName;

    public static function tearDownAfterClass(): void
    {
        if (file_exists(self::$fileName)) {
            unlink(self::$fileName);
        }
        parent::tearDownAfterClass();
    }

    public function tearDown(): void
    {
        if (file_exists(self::$fileName)) {
            echo "\n\nAfter running '" . $this->getName() . "', the content of '" . self::$fileName . "'\n";
            echo file_get_contents(self::$fileName);
            echo "\n";
        }
        parent::tearDown();
    }

    public function testFileCreated(): void
    {
        tCase::assertNotEmpty(self::$fileName);
        tCase::assertFileDoesNotExist(self::$fileName);
        if ($this->isExists('info')) {
            $this->o2t->info('Write a log line');
        }
        tCase::assertFileExists(self::$fileName);
    }

    private function isExists(?string $methodName = ''): bool
    {
        $methodName = $methodName ?? $this->methodName;

        return method_exists($this->o2t, $methodName);
    }

    public function testWriteMessage(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->getName() . $this->MESSAGE_1);
        }
        tCase::assertTrue(true);
    }

    public function testWriteTwoMessages(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->getName() . $this->MESSAGE_1, $this->MESSAGE_2);
        }
        tCase::assertTrue(true);
    }

    public function testWriteThreeMessages(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->getName() . $this->MESSAGE_1, $this->MESSAGE_2, $this->MESSAGE_3);
        }
        tCase::assertTrue(true);
    }

    public function testWriteSimpleContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out('', $this->getName() . $this->MESSAGE_1);
        }
        tCase::assertTrue(true);
    }

    public function testWriteContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out('', $this->getName() . $this->MESSAGE_1, $this->MESSAGE_2, $this->MESSAGE_3);
        }
        tCase::assertTrue(true);
    }

    public function testWriteComplexContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->getName() . $this->MESSAGE_1, $this->COMPLEX_CONTEXT);
        }
        tCase::assertTrue(true);
    }

    public function testWriteMessageAndContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->getName() . $this->MESSAGE_1, [$this->MESSAGE_2, $this->MESSAGE_3]);
        }
        tCase::assertTrue(true);
    }

    public function testLoggerMethods(): void
    {
        $loggerMethods = ['debug', 'info', 'notice', 'warning', 'alert', 'emergency'];

        foreach ($loggerMethods as $loggerMethod) {
            if ($this->isExists($loggerMethod)) {
                $this->o2t->$loggerMethod($this->getName() . $this->MESSAGE_1 . '-' . $loggerMethod, $this->COMPLEX_CONTEXT);
            }
        }
        if ($this->isExists('log')) {
            $this->o2t->log($this->o2t::INFO, $this->getName() . $this->MESSAGE_1 . '-log', $this->COMPLEX_CONTEXT);
        }
        tCase::assertTrue(true);
    }
}
