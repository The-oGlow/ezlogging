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

trait TraitTestFileLogger
{
    /** @var string */
    private $MESSAGE_1       = '-message 1';

    /** @var string */
    private $MESSAGE_2       = 'message 2';

    /** @var string */
    private $MESSAGE_3       = 'message 3';

    /** @var array<mixed,mixed> */
    private $COMPLEX_CONTEXT = ['id1' => 'val1', 'id2' => 'val2', 3 => 3, 4 => [40, 41, ['idx400' => 'sub400', 'sub 401']]];

    /** @var string */
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
            echo "\n\nAfter running '" . $this->currentTestMethod() . "', the content of '" . self::$fileName . "'\n";
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

    /**
     * @return string
     *
     * @psalm-suppress InternalMethod
     */
    protected function currentTestMethod(): string
    {
        return $this->getName();
    }

    private function isExists(?string $methodName = null): bool
    {
        $methodName = $methodName ?? $this->methodName;

        return method_exists($this->o2t, $methodName);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteMessage(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->currentTestMethod() . $this->MESSAGE_1);
            echo "1";
        }
        echo "2";

        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteTwoMessages(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->currentTestMethod() . $this->MESSAGE_1, $this->MESSAGE_2);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteThreeMessages(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->currentTestMethod() . $this->MESSAGE_1, $this->MESSAGE_2, $this->MESSAGE_3);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteSimpleContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out('', $this->currentTestMethod() . $this->MESSAGE_1);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out('', $this->currentTestMethod() . $this->MESSAGE_1, $this->MESSAGE_2, $this->MESSAGE_3);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteComplexContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->currentTestMethod() . $this->MESSAGE_1, $this->COMPLEX_CONTEXT);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteMessageAndContext(): void
    {
        if ($this->isExists()) {
            $this->o2t->out($this->currentTestMethod() . $this->MESSAGE_1, [$this->MESSAGE_2, $this->MESSAGE_3]);
        }
        tCase::assertTrue(true);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testLoggerMethods(): void
    {
        $loggerMethods = ['debug', 'info', 'notice', 'warning', 'alert', 'emergency'];

        foreach ($loggerMethods as $loggerMethod) {
            if ($this->isExists($loggerMethod)) {
                // @phpstan-ignore method.dynamicName
                $this->o2t->$loggerMethod($this->currentTestMethod() . $this->MESSAGE_1 . '-' . $loggerMethod, $this->COMPLEX_CONTEXT);
            }
        }
        if ($this->isExists('log')) {
            $this->o2t->log($this->o2t::INFO, $this->currentTestMethod() . $this->MESSAGE_1 . '-log', $this->COMPLEX_CONTEXT);
        }
        tCase::assertTrue(true);
    }
}
