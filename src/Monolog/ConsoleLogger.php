<?php

declare(strict_types=1);

namespace Monolog;

use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\PaddingProcessor;
use Monolog\Processor\ProcessorInterface;

class ConsoleLogger extends AbstractEasyGoingLogger
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return $this->getConsoleHandler();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PaddingProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new EasyGoingFormatter();
    }
}
