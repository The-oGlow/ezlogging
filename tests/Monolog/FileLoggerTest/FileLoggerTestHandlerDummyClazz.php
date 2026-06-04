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

use Monolog\Handler\HandlerInterface;

/**
 * A simple clazz which will be tested by the test clazz.
 */
class FileLoggerTestHandlerDummyClazz implements HandlerInterface
{
    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function isHandling(array $record): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function handle(array $record): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    #[\Override]
    public function handleBatch(array $records): void
    {
        // nothing2do
    }

    #[\Override]
    public function close(): void
    {
        // nothing2do
    }
}
