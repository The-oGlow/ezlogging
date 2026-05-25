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

namespace Monolog\FileLoggerTest;

use Monolog\Test\TestCase as tCase;
use ollily\Tools\String\ImplodeTrait;
use Psr\Log\LoggerInterface;

/**
 * This trait tests the FileLogger.
 *
 * @see \Monolog\FileLogger
 */
trait FileLoggerTestTrait
{
    use ImplodeTrait;

    public bool $silentIsExists = false;

    private string $MESSAGE_EMPTY = '';

    private string $MESSAGE_1 = '-message_1';

    private string $MESSAGE_2 = 'message_2';

    private string $CONTEXT_1 = 'context_1';

    private string $CONTEXT_2 = 'context_2';

    /** @var array<mixed,mixed> */
    private array $COMPLEX_CONTEXT = ['id1' => 'val1', 'id2' => 'val2', 3 => 3, 4 => [40, 41, ['idx400' => 'sub400', 'sub401']]];

    private string $PH_CNTX = '#CNTX#';

    private string $PH_MSG = '#MSG#';

    private string $REGEX_MSG = '/.*^("|)#MSG#("|)$.*/m';

    private string $REGEX_MSG_N_CNTX = '/.*^("|)#MSG#("|);("|)#CNTX#("|)$.*/m';

    private string $methodName = 'out';

    private static string $fileName;

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
            echo "\ntearDown()\nAfter running '" . $this->currentTestMethod() . "', the content of '" . self::$fileName . "'\n";
            echo $this->currentFileContent(self::$fileName);
            echo "\n";
        }
        self::tearDownAfterClass();
        parent::tearDown();
    }

    public function testFileCreated(): void
    {
        tCase::assertNotEmpty(self::$fileName);
        tCase::assertFileDoesNotExist(self::$fileName);
        if ($this->isExists('info')) {
            $this->o2t->info('Write text into:', [self::$fileName]);
        }
        tCase::assertFileExists(self::$fileName);
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteOneMessage(): void
    {
        $message = $this->MESSAGE_1;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage);

            $expectedMsg = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG);

            $this->verifyFileContent($expectedMsg, self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteOneMessageOneContext(): void
    {
        $message = $this->MESSAGE_1;
        $context = $this->CONTEXT_1;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = (is_array($context) ? self::implode_recursive(self::DEFAULT_ITEM_SEP, $context) : $context);

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteOneMessageTWoContexts(): void
    {
        $message  = $this->MESSAGE_1;
        $context  = $this->CONTEXT_1;
        $context2 = $this->CONTEXT_2;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context, $context2);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = self::implode_recursive(self::DEFAULT_ITEM_SEP, [$context, $context2]);

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,RedundantCondition
     */
    public function testWriteEmptyMessageSimpleContext(): void
    {
        $message = $this->MESSAGE_EMPTY;
        $context = $this->CONTEXT_1;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = (is_array($context) ? self::implode_recursive(self::DEFAULT_ITEM_SEP, $context) : $context);

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteEmptyMessageMultipleContext(): void
    {
        $message  = $this->MESSAGE_EMPTY;
        $context  = $this->MESSAGE_1;
        $context2 = $this->CONTEXT_1;
        $context3 = $this->CONTEXT_2;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context, $context2, $context3);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = self::implode_recursive(self::DEFAULT_ITEM_SEP, [$context, $context2, $context3]);

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteMessageComplexContext(): void
    {
        $message = $this->MESSAGE_1;
        $context = $this->COMPLEX_CONTEXT;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = is_array($context) ? str_replace(['[', ']'], '', self::implode_recursive(self::DEFAULT_ITEM_SEP, $context)) : $context;

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,RedundantCondition,TypeDoesNotContainType
     */
    public function testWriteMessageAndContext(): void
    {
        $message = $this->MESSAGE_1;
        $context = [$this->CONTEXT_1, $this->CONTEXT_2];

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);

            $expectedMsg     = str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX);
            $expectedContext = is_array($context) ? self::implode_recursive(self::DEFAULT_ITEM_SEP, $context) : $context;

            $this->verifyFileContent(str_replace($this->PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    public function testLoggerMethods(): void
    {
        $loggerMethods = ['debug', 'info', 'notice', 'warning', 'alert', 'emergency'];

        foreach ($loggerMethods as $loggerMethod) {
            if ($this->isExists($loggerMethod)) {
                $this->o2t->$loggerMethod($this->currentTestMethod() . $this->MESSAGE_1 . '-' . $loggerMethod, $this->COMPLEX_CONTEXT);
            }
        }
        if ($this->isExists('log')) {
            $this->o2t->log($this->o2t::INFO, $this->currentTestMethod() . $this->MESSAGE_1 . '-log', $this->COMPLEX_CONTEXT);
        }
        tCase::assertTrue(true);
    }

    protected function currentTestMethod(): string
    {
        return $this->name();
    }

    protected function currentFileContent(string $fileName): string
    {
        $content = '';
        if (file_exists($fileName)) {
            $content = file_get_contents($fileName);
        }
        if ($content == false) {
            $content = '';
        }

        return $content;
    }

    protected function verifyFileContent(string $expected, string $fileName): void
    {
        $actual = $this->currentFileContent($fileName);

        self::assertMatchesRegularExpression($expected, $actual);
    }

    /**
     * @param null|string          $methodName
     * @param null|LoggerInterface $logger
     *
     * @return bool
     */
    private function isExists(?string $methodName = null, ?LoggerInterface $logger = null): bool
    {
        $methodName ??= $this->methodName;
        $exists     = method_exists($this->o2t, $methodName);

        if (!$exists) {
            if (isset($logger)) {
                $logger->warning('Method not exists: ', [$this->methodName]);
            }
            if ($this->silentIsExists) {
                self::fail('Method not exists: ' . $this->methodName);
            } else {
                self::assertTrue(true);
            }
        }

        return $exists;
    }
}
