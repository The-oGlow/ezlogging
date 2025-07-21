<?php

declare(strict_types=1);

namespace Monolog;

use DateTimeZone;
use Monolog\Handler\HandlerInterface;

class FileLogger extends ConsoleLogger
{
    /**
     *
     * @param string $name
     * @param string $pathToFile
     * @param HandlerInterface[] $handlers
     *            Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[] $processors
     *            Optional array of processors
     * @param DateTimeZone|null $timezone
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
}
