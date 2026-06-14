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

namespace Monolog\AbstractEasyGoingLoggerTest;

use Monolog\ConsoleLogger;
use Monolog\CsvLogger;
use Monolog\DoNothingLogger;
use Monolog\FileLogger;
use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\CsvHandler;
use Monolog\Handler\FileHandler;
use Monolog\Handler\NoopHandler;
use Monolog\Handler\TestHandler;
use Monolog\LoggerAdapter;
use Monolog\PlainLogger;
use Monolog\Processor\PaddingProcessor;
use Monolog\Processor\PlainProcessor;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use Psr\Log\LoggerInterface;

trait AbstractEasyGoingLoggerTestTrait
{
    use UnavailableMethodsTrait;

    public function testConfiguration(): void
    {
        $expectedClazz = [
            PlainLogger::class,
            DoNothingLogger::class,
            FileLogger::class,
            CsvLogger::class,
            AbstractEasyGoingLoggerTestDummyClazz::class,
            ConsoleLogger::class,
            LoggerAdapter::class,
        ];

        $actualClazz = get_class($this->o2t);

        /** @psalm-suppress RedundantCondition */
        self::assertNotFalse($actualClazz);
        self::assertContains($actualClazz, $expectedClazz);

        $handlers = $this->callMethodOnO2t('getHandlers');
        self::assertNotEmpty($handlers);
        if (count($handlers) == 2) {
            self::assertInstanceOf(
                TestHandler::class,
                $handlers[0],
                sprintf('When having two handler, the first handler must be the Monolog/Handler/TestHandler: \'%s\'', $actualClazz)
            );
        } else {
            self::assertCount(
                1,
                $handlers,
                sprintf('Has unexptected number of handlers: \'%s\' => %s', $actualClazz, print_r($handlers, true))
            );
        }
        /**
         * @psalm-suppress RedundantPropertyInitializationCheck
         */
        if (isset($this->o2t)) {
            self::assertInstanceOf(LoggerInterface::class, $this->o2t);
        }
    }

    public function testGetDefaultHandler(): void
    {
        $expectedResult = [
            AbstractEasyGoingLoggerTestHandlerDummyClazz::class,
            NoopHandler::class,
            ConsoleHandler::class,
            CsvHandler::class,
            FileHandler::class,
            TestHandler::class,
            ];

        $actualResult = $this->callMethodOnO2t('getDefaultHandler');

        self::assertNotNull($actualResult);
        self::assertContains($actualResult::class, $expectedResult);
    }

    public function testGetDefaultProcessor(): void
    {
        $expectedResult = [
            PlainProcessor::class,
            AbstractEasyGoingLoggerTestProcessorDummyClazz::class,
            PaddingProcessor::class,
        ];

        $actualResult = $this->callMethodOnO2t('getDefaultProcessor');

        self::assertNotNull($actualResult);
        self::assertContains($actualResult::class, $expectedResult);
    }

    public function testGetDefaultFormatter(): void
    {
        $expectedResult = [
            PlainFormatter::class,
            AbstractEasyGoingLoggerTestFormatterDummyClazz::class,
            EasyGoingFormatter::class,
        ];

        $actualResult = $this->callMethodOnO2t('getDefaultFormatter');

        self::assertNotNull($actualResult);
        self::assertContains($actualResult::class, $expectedResult);
    }
}
