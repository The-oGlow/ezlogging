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

use DateTimeZone;
use Monolog\Handler\FileHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;

class FileLogger extends ConsoleLogger
{
    /**
     *
     * @param string             $name
     * @param string             $pathToFile
     * @param HandlerInterface[] $handlers
     *            Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors
     *            Optional array of processors
     * @param DateTimeZone|null  $timezone
     */
    public function __construct(string $name, string $pathToFile, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct(
            $name,
            (empty($handlers) ? [$this->getFileHandler($pathToFile, $name)] : $handlers),
            $processors,
            $timezone
        );
    }

    protected function getFileHandler(string $pathToFile, string $fileName): StreamHandler
    {
        return new FileHandler($pathToFile, $fileName);
    }

    public function getFileName(): string
    {
        $fileName = '';
        foreach ($this->getHandlers() as $handler)
        {
            if ($handler instanceof FileHandler)
            {
                $fileName = $handler->getFileName();
            }
        }

        return $fileName;
    }
}
