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

    /** @psalm-suppress TypeDoesNotContainType */
    public function testConfiguration(): void
    {
        switch (true) {
            case (PlainLogger::class === $this->o2t::class): { // @phpstan-ignore identical.alwaysFalse
                $this::assertInstanceOf(PlainLogger::class, $this->o2t);
                break;
            }
            default: {
                $this::assertInstanceOf(ConsoleLogger::class, $this->o2t);
            }
        }

        $handlers = $this->o2t->getHandlers();
        $this::assertNotEmpty($handlers);
        $this::assertCount(1, $handlers);
        $this::assertInstanceOf(ConsoleHandler::class, $handlers[0]);
    }

    public function testGetDefaultHandler(): void
    {
        $result = $this->callMethodOnO2t('getDefaultHandler');
        $this::assertNotNull($result);
        $this::assertInstanceOf(ConsoleHandler::class, $result);
    }

    /** @psalm-suppress TypeDoesNotContainType */
    public function testGetDefaultProcessor(): void
    {
        $result = $this->callMethodOnO2t('getDefaultProcessor');
        $this::assertNotNull($result);
        switch (true) {
            case (PlainLogger::class === $this->o2t::class): { // @phpstan-ignore identical.alwaysFalse
                $this::assertInstanceOf(PlainProcessor::class, $result);
                break;
            }
            default: {
                $this::assertInstanceOf(PaddingProcessor::class, $result);
            }
        }
    }

    /** @psalm-suppress TypeDoesNotContainType */
    public function testGetDefaultFormatter(): void
    {
        $result = $this->callMethodOnO2t('getDefaultFormatter');
        $this::assertNotNull($result);
        switch (true) {
            case (PlainLogger::class === $this->o2t::class): { // @phpstan-ignore identical.alwaysFalse
                $this::assertInstanceOf(PlainFormatter::class, $result);
                break;
            }
            default: {
                $this::assertInstanceOf(EasyGoingFormatter::class, $result);
            }
        }
    }
}
