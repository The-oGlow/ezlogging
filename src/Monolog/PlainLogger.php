<?php

declare(strict_types=1);

namespace Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\PlainFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Processor\PlainProcessor;
use Monolog\Processor\ProcessorInterface;

class PlainLogger extends AbstractEasyGoingLogger
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return $this->getConsoleHandler();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }

    public function out($message): void
    {
        parent::info($message);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->out($message);
    }

    public function emergency($message, array $context = []): void
    {
        $this->out($message);
    }

    public function alert($message, array $context = []): void
    {
        $this->out($message);
    }

    public function warning($message, array $context = []): void
    {
        $this->out($message);
    }

    public function notice($message, array $context = []): void
    {
        $this->out($message);
    }

    public function info($message, array $context = []): void
    {
        $this->out($message);
    }

    public function debug($message, array $context = []): void
    {
        $this->out($message);
    }
}
