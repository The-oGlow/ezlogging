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

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\ProcessorInterface;

class AbstractEasyGoingLoggerTestClazz extends AbstractEasyGoingLogger
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return new AbstractEasyGoingLoggerTestHandlerClazz();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new AbstractEasyGoingLoggerTestProcessorClazz();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new AbstractEasyGoingLoggerTestFormatterClazz();
    }
}
/**
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses, PSR1.Files.SideEffects.FoundWithSymbols
 */
class AbstractEasyGoingLoggerTestHandlerClazz implements HandlerInterface
{
    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function isHandling(array $record): bool
    {
        return true;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function handle(array $record): bool
    {
        return true;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function handleBatch(array $records): void
    {
        // nothing2do
    }

    public function close(): void
    {
        // nothing2do
    }
}

class AbstractEasyGoingLoggerTestProcessorClazz implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        return $record;
    }
}

class AbstractEasyGoingLoggerTestFormatterClazz implements FormatterInterface
{
    public function format(array $record)
    {
        return $record;
    }

    public function formatBatch(array $records)
    {
        return $records;
    }
}
