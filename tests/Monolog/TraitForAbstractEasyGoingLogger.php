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
use Monolog\Processor\PaddingProcessor;
use Monolog\Processor\PlainProcessor;
use ollily\Tools\Reflection\UnavailableMethodsTrait;

trait TraitForAbstractEasyGoingLogger
{
    use UnavailableMethodsTrait;

    /**
     * @psalm-suppress TypeDoesNotContainType
     * @psalm-suppress DocblockTypeContradiction
     */
    public function testConfiguration(): void
    {
        switch (true) {
            case (PlainLogger::class === get_class($this->o2t)) : {
                static::assertInstanceOf(PlainLogger::class, $this->o2t);
                break;
            }
            case (AbstractEasyGoingLoggerTestClazz::class === get_class($this->o2t)) : {
                static::assertInstanceOf(AbstractEasyGoingLoggerTestClazz::class, $this->o2t);
                break;
            }
            default: {
                static::assertInstanceOf(ConsoleLogger::class, $this->o2t);
            }
        }

        $handlers = $this->callMethodOnO2t('getHandlers');
        static::assertNotEmpty($handlers);
        static::assertCount(1, $handlers);
        static::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
    }

    public function testGetDefaultHandler(): void
    {
        $result = $this->callMethodOnO2t('getDefaultHandler');
        static::assertNotNull($result);
        switch (true) {
            case (AbstractEasyGoingLoggerTestClazz::class === get_class($this->o2t)) : {
                static::assertInstanceOf(AbstractEasyGoingLoggerTestHandlerClazz::class, $result);
                break;
            }
            default: {
                static::assertInstanceOf(ConsoleHandler::class, $result);
            }
        }
    }

    /**
     * @psalm-suppress TypeDoesNotContainType
     */
    public function testGetDefaultProcessor(): void
    {
        $result = $this->callMethodOnO2t('getDefaultProcessor');
        static::assertNotNull($result);
        switch (true) {
            case (PlainLogger::class === get_class($this->o2t)): {
                static::assertInstanceOf(PlainProcessor::class, $result);
                break;
            }
            case (AbstractEasyGoingLoggerTestClazz::class === get_class($this->o2t)) : {
                static::assertInstanceOf(AbstractEasyGoingLoggerTestProcessorClazz::class, $result);
                break;
            }
            default: {
                static::assertInstanceOf(PaddingProcessor::class, $result);
            }
        }
    }

    /**
     * @psalm-suppress TypeDoesNotContainType
     */
    public function testGetDefaultFormatter(): void
    {
        $result = $this->callMethodOnO2t('getDefaultFormatter');
        static::assertNotNull($result);
        switch (true) {
            case (PlainLogger::class === get_class($this->o2t)): {
                static::assertInstanceOf(PlainFormatter::class, $result);
                break;
            }
            case (AbstractEasyGoingLoggerTestClazz::class === get_class($this->o2t)) : {
                static::assertInstanceOf(AbstractEasyGoingLoggerTestFormatterClazz::class, $result);
                break;
            }
            default: {
                static::assertInstanceOf(EasyGoingFormatter::class, $result);
            }
        }
    }
}
