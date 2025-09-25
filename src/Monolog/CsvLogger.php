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
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\CsvHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PlainProcessor;
use Monolog\Formatter\FormatterInterface;
use Monolog\Processor\ProcessorInterface;

class CsvLogger extends FileLogger
{
    public function __construct(
        string $name,
        string $pathToFile,
        array $handlers = [],
        array $processors = [],
        ?DateTimeZone $timezone = null
    ) {
        parent::__construct(
            $name,
            $pathToFile,
            (empty($handlers) ? [$this->getCsvHandler($pathToFile, $name)] : $handlers),
            $processors,
            $timezone
        );
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }

    private function getCsvHandler(string $pathToFile, string $fileName): StreamHandler
    {
        return new CsvHandler($pathToFile, $fileName);
    }
}
