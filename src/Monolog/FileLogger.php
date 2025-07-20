<?php

declare(strict_types=1);

namespace Monolog;

class FileLogger extends ConsoleLogger
{
    public function __construct($name, $pathToFile, array $handlers = [], array $processors = [], $timezone = null)
    {
        parent::__construct(
            $name,
            $handlers ?? [$this->getFileHandler($pathToFile, $name)],
            $processors,
            $timezone
        );
    }
}
