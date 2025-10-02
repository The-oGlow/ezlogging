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
use ollily\Tools\String\ImplodeTrait;

trait TraitTestFileLogger
{
    use ImplodeTrait;

    /** @var string */
    private $MESSAGE_1 = '-message 1';

    /** @var string */
    private $MESSAGE_2 = 'message 2';

    /** @var string */
    private $MESSAGE_3 = 'message 3';

    /** @var array<mixed,mixed> */
    private $COMPLEX_CONTEXT = ['id1' => 'val1', 'id2' => 'val2', 3 => 3, 4 => [40, 41, ['idx400' => 'sub400', 'sub401']]];

    /** @var string */
    private $STANDARD_ITEM_SEP = ';';

    /** @var string */
    private $IMPLODE_SEP = '";"';

    /** @var string */
    private $PH_CNTX = '#CNTX#';

    /** @var string */
    private $PH_MSG = '#MSG#';

    /** @var string */
    private $REGEX_MSG = '/.*^"#MSG#"$.*/m';

    /** @var string */
    private $REGEX_MSG_N_CNTX = '/.*^("|)#MSG#("|);("|)#CNTX#("|)$.*/m';

    /** @var string */
    private $methodName = 'out';

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
        static::tearDownAfterClass();
        parent::tearDown();
    }

    /**
     * var FL $this->o2t.
     */
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
        $exists     = method_exists($this->o2t, $methodName);
        if (!$exists) {
            if (isset($this->logger)) {
                $this->logger->warning('Method not exists: ', [$this->methodName]);
            }
            static::fail('Method not exists: ' . $this->methodName);
        }

        return $exists;
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteMessage(): void
    {
        $message = $this->MESSAGE_1;
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage);
            $this->expectOutputRegex(str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG));
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,DocblockTypeContradiction,NoValue,RedundantConditionGivenDocblockType
     */
    public function testWriteTwoMessages(): void
    {
        $message = $this->MESSAGE_1;
        $context = $this->MESSAGE_2;
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_CNTX,
                    (is_array($context) ? implode($this->STANDARD_ITEM_SEP, $context) : $context),
                    str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX)
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteThreeMessages(): void
    {
        $message  = $this->MESSAGE_1;
        $context  = $this->MESSAGE_2;
        $context2 = $this->MESSAGE_3;
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context, $context2);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_CNTX,
                    implode($this->IMPLODE_SEP, [$context, $context2]),
                    str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX)
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,TypeDoesNotContainType,NoValue,RedundantCondition
     */
    public function testWriteSimpleContextEmptyMessage(): void
    {
        $message = '';
        $context = $this->MESSAGE_1;
        if ($this->isExists()) {
            $renderContext = $this->currentTestMethod() . $context;
            $this->o2t->out($message, $renderContext);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_MSG,
                    (is_array($renderContext) ? implode($this->STANDARD_ITEM_SEP, $renderContext) : $renderContext),
                    $this->REGEX_MSG
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
    public function testWriteContextEmptyMessage(): void
    {
        $message  = '';
        $context  = $this->MESSAGE_1;
        $context2 = $this->MESSAGE_2;
        $context3 = $this->MESSAGE_3;
        if ($this->isExists()) {
            $renderContext = $this->currentTestMethod() . $context;
            $this->o2t->out($message, $renderContext, $context2, $context3);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_MSG,
                    implode($this->IMPLODE_SEP, [$renderContext, $context2, $context3]),
                    $this->REGEX_MSG
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,RedundantConditionGivenDocblockType,DocblockTypeContradiction,RedundantCondition
     */
    public function testWriteComplexContext(): void
    {
        $message = $this->MESSAGE_1;
        $context = $this->COMPLEX_CONTEXT;
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_CNTX,
                    (is_array($context) ? implode($this->STANDARD_ITEM_SEP, $this->array_flatten($context)) : $context),
                    str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX)
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod,RedundantCondition,TypeDoesNotContainType
     */
    public function testWriteMessageAndContext(): void
    {
        $message = $this->MESSAGE_1;
        $context = [$this->MESSAGE_2, $this->MESSAGE_3];
        if ($this->isExists()) {
            $renderMessage = $this->currentTestMethod() . $message;
            $this->o2t->out($renderMessage, $context);
            $this->expectOutputRegex(
                str_replace(
                    $this->PH_CNTX,
                    (is_array($context) ? implode($this->IMPLODE_SEP, $context) : $context),
                    str_replace($this->PH_MSG, $renderMessage, $this->REGEX_MSG_N_CNTX)
                )
            );
        }
    }

    /**
     * @psalm-suppress UndefinedMethod
     */
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
}
