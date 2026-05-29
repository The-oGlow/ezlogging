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
use PHPUnit\Framework\Attributes\DataProvider;
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

    private static string $MESSAGE_EMPTY = '';

    private static string $MESSAGE_1 = '-message_1';

    private static string $MESSAGE_2 = 'message_2';

    private static string $CONTEXT_1 = 'context_1';

    private static string $CONTEXT_2 = 'context_2';

    /** @var array<mixed,mixed> */
    private static array $COMPLEX_CONTEXT = ['id1' => 'val1', 'id2' => 'val2', 3 => 3, 4 => [40, 41, ['idx400' => 'sub400', 'sub401']]];

    private static string $PH_CNTX = '#CNTX#';

    private static string $PH_MSG = '#MSG#';

    private static string $REGEX_MSG = '/.*^("|)#MSG#("|)$.*/m';

    private static string $REGEX_MSG_N_CNTX = '/.*^("|)#MSG#("|);("|)#CNTX#("|)$.*/m';

    private static string $methodName = 'out';

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
            echo "\ntearDown()\nAfter running '" . $this->currentTestMethod() . "', the content of '" . self::$fileName . "':\n\"\n";
            echo $this->currentFileContent(self::$fileName);
            echo "\n\"\n";
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
        $message = self::$MESSAGE_1;

        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage);

            $expectedMsg = str_replace(self::$PH_MSG, $renderMessage, self::$REGEX_MSG);

            $this->verifyFileContent($expectedMsg, self::$fileName);
        }
    }

    /**
     * @param string $expectedMsg
     * @param string $expectedContext
     * @param mixed  $message
     * @param mixed  $context
     *
     * @psalm-suppress UndefinedMethod
     */
    #[DataProvider('providerWriteMessageWithContext')]
    public function testWriteMessageWithContext(string $expectedMsg, string $expectedContext, mixed $message, mixed $context): void
    {
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;

            $this->o2t->out($renderMessage, $context);

            $this->verifyFileContent(str_replace(self::$PH_CNTX, $expectedContext, $expectedMsg), self::$fileName);
        }
    }

    /**
     * @return array<mixed,mixed>
     */
    public static function providerWriteMessageWithContext(): array
    {
        $testMethod = 'testWriteMessageWithContext';
        $renderMessage = $testMethod . self::$MESSAGE_1;
        $expectedMsg = str_replace(self::$PH_MSG, $renderMessage, self::$REGEX_MSG_N_CNTX);
        $renderEmptyMessage = $testMethod . self::$MESSAGE_EMPTY;
        $expectedEmptyMsg = str_replace(self::$PH_MSG, $renderEmptyMessage, self::$REGEX_MSG_N_CNTX);

        return [
            'oneMessageOneContext' => [
                $expectedMsg,
                self::implode_recursive(self::DEFAULT_ITEM_SEP, self::$CONTEXT_1),
                self::$MESSAGE_1,
                self::$CONTEXT_1,
            ],
            'oneMessageTwoContexts' => [
                $expectedMsg,
                self::implode_recursive(self::DEFAULT_ITEM_SEP, [self::$CONTEXT_1, self::$CONTEXT_2]),
                self::$MESSAGE_1,
                [self::$CONTEXT_1,self::$CONTEXT_2],
            ],
            'emptyMessageSimpleContext' => [
                $expectedEmptyMsg,
                 self::implode_recursive(self::DEFAULT_ITEM_SEP, self::$CONTEXT_1),
                self::$MESSAGE_EMPTY,
                self::$CONTEXT_1,
            ],
            'emptyMessageMultipleContext' => [
                $expectedEmptyMsg,
                self::implode_recursive(self::DEFAULT_ITEM_SEP, [self::$MESSAGE_1, self::$CONTEXT_1, self::$CONTEXT_2]),
                self::$MESSAGE_EMPTY,
                [self::$MESSAGE_1, self::$CONTEXT_1, self::$CONTEXT_2],
            ],
            'messageComplexContext' => [
                $expectedEmptyMsg,
                str_replace(['[', ']'], '', self::implode_recursive(self::DEFAULT_ITEM_SEP, self::$COMPLEX_CONTEXT)),
                self::$MESSAGE_EMPTY,
                self::$COMPLEX_CONTEXT,
            ],
            'messageAndContext' => [
                $expectedMsg,
                self::implode_recursive(self::DEFAULT_ITEM_SEP, [self::$CONTEXT_1, self::$CONTEXT_2]),
                self::$MESSAGE_1,
                [self::$CONTEXT_1, self::$CONTEXT_2],
            ],
        ];
    }

    public function testLoggerMethods(): void
    {
        $loggerMethods = ['debug', 'info', 'notice', 'warning', 'alert', 'emergency'];

        foreach ($loggerMethods as $loggerMethod) {
            if ($this->isExists($loggerMethod)) {
                $this->o2t->$loggerMethod($this->currentTestMethod() . self::$MESSAGE_1 . '-' . $loggerMethod, self::$COMPLEX_CONTEXT);
            }
        }
        if ($this->isExists('log')) {
            $this->o2t->log($this->o2t::INFO, $this->currentTestMethod() . self::$MESSAGE_1 . '-log', self::$COMPLEX_CONTEXT);
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
        $methodName ??= self::$methodName;
        $exists     = method_exists($this->o2t, $methodName);

        if (!$exists) {
            if (isset($logger)) {
                $logger->warning('Method not exists: ', [$methodName]);
            }
            if ($this->silentIsExists) {
                self::fail('Method not exists: ' . $methodName);
            } else {
                self::assertTrue(true);
            }
        }

        return $exists;
    }
}
