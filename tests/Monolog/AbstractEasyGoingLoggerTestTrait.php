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

use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\NoopHandler;
use Monolog\Processor\PaddingProcessor;
use Monolog\Processor\PlainProcessor;
use ollily\Tools\Reflection\UnavailableMethodsTrait;

trait AbstractEasyGoingLoggerTestTrait
{
    use UnavailableMethodsTrait;

    /**
     * @psalm-suppress DocblockTypeContradiction
     */
    public function testConfiguration(): void
    {
        $expectedClazz = [
            PlainLogger::class,
            DoNothingLogger::class,
            FileLogger::class,
            CsvLogger::class,
            AbstractEasyGoingLoggerTestClazz::class,
            ConsoleLogger::class
        ];

        $actualClazz = get_class($this->o2t);

        /** @psalm-suppress RedundantCondition */
        static::assertNotFalse($actualClazz);
        static::assertContains($actualClazz, $expectedClazz);

        $handlers = $this->callMethodOnO2t('getHandlers');
        static::assertNotEmpty($handlers);
        static::assertCount(1, $handlers, 'Has uneven number of handlers: ' . $actualClazz . ' => ' . print_r($handlers, true));
        /**
         * @psalm-suppress RedundantConditionGivenDocblockType,RedundantPropertyInitializationCheck
         */
        if (isset($this->o2t) && $this->o2t instanceof ConsoleLogger) {
            static::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
        }
    }

    public function testGetDefaultHandler(): void
    {
        $expectedResult = [AbstractEasyGoingLoggerTestHandlerClazz::class, NoopHandler::class, ConsoleHandler::class];

        $actualResult = $this->callMethodOnO2t('getDefaultHandler');

        static::assertNotNull($actualResult);
        static::assertContains(get_class($actualResult), $expectedResult);
    }

    public function testGetDefaultProcessor(): void
    {
        $expectedResult = [
            PlainProcessor::class,
            AbstractEasyGoingLoggerTestProcessorClazz::class,
            PaddingProcessor::class
        ];

        $actualResult = $this->callMethodOnO2t('getDefaultProcessor');

        static::assertNotNull($actualResult);
        static::assertContains(get_class($actualResult), $expectedResult);
    }

    public function testGetDefaultFormatter(): void
    {
        $expectedResult = [
            PlainFormatter::class,
            AbstractEasyGoingLoggerTestFormatterClazz::class,
            EasyGoingFormatter::class
        ];

        $actualResult = $this->callMethodOnO2t('getDefaultFormatter');

        static::assertNotNull($actualResult);
        static::assertContains(get_class($actualResult), $expectedResult);
    }
}
