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

/**
 * Class FileLogger.
 *
 * @see ConsoleLogger
 * @see FileHandler
 */
class FileLogger extends ConsoleLogger
{
    /**
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param string             $pathToFile The full path to the output folder
     * @param handlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc
     * @param callable[]         $processors Optional array of processors
     * @param null|DateTimeZone  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     * @param mixed              $level      The output level (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @see AbstractEasyGoingLogger::LEVEL_DEFAULT
     */
    public function __construct(
        string $name,
        string $pathToFile,
        array $handlers = [],
        array $processors = [],
        ?DateTimeZone $timezone = null,
        $level = self::LEVEL_DEFAULT
    ) {
        if (empty($handlers)) {
            $handlers = [$this->getFileHandler($pathToFile, $name)];
        } else {
            array_unshift($handlers, $this->getFileHandler($pathToFile, $name));
        }
        parent::__construct($name, $level, $handlers, $processors, $timezone);
    }

    /**
     * @param string $pathToFile The full path to the output folder
     * @param string $fileName   The name of the output file
     * @param mixed  $level      The output level (Default: {@link AbstractEasyGoingLogger::LEVEL_DEFAULT})
     *
     * @return StreamHandler the stream handler for the file
     */
    protected function getFileHandler(string $pathToFile, string $fileName, $level = self::LEVEL_DEFAULT): StreamHandler
    {
        return new FileHandler($pathToFile, $fileName, $level);
    }

    /**
     * @return string The full filename (with path) of the output file or empty string
     */
    public function getFileName(): string
    {
        $fileName = '';
        foreach ($this->getHandlers() as $handler) {
            if ($handler instanceof FileHandler) {
                $fileName = $handler->getFileName();
            }
        }

        return $fileName;
    }
}
