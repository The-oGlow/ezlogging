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
use Stringable;

class CsvLogger extends FileLogger
{
    /** @var string  */
    private $itemSeparator;

    /** @var string  */
    private $itemEnclosure;
    /** @var array<mixed>
     * @phpstan-ignore property.onlyWritten */
    private $header;

    /**
     * CsvLogger constructor.
     *
     * @param string $name
     * @param string $pathToFile
     * @param array<mixed>  $header
     * @param string $itemSeparator
     * @param string $itemEnclosure
     */
    public function __construct(
        string $name,
        string $pathToFile,
        array $header = [],
        string $itemSeparator = CsvHandler::ITEM_SEP,
        string $itemEnclosure = CsvHandler::TEXT_SEP
    ) {
        $this->itemSeparator = $itemSeparator;
        $this->itemEnclosure = $itemEnclosure;
        $this->header = $header;
        parent::__construct($name, $pathToFile, [], [], null);
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new PlainProcessor();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new PlainFormatter();
    }

    /**
     * @inheritdoc
     */
    protected function getFileHandler(string $pathToFile, string $fileName): StreamHandler
    {
        $handler = new CsvHandler($pathToFile, $fileName, $this->itemSeparator, $this->itemEnclosure);
        $handler->setFormatter($this->getDefaultFormatter());

        return $handler;
    }

    /**
     * @param string|Stringable $message
     */
    public function out($message): void
    {
        parent::info($message);
    }

    /**
     * @param mixed             $level
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function log($level, $message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function emergency($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function alert($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function warning($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function notice($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function info($message, array $context = []): void
    {
        $this->out($message);
    }

    /**
     * @param string|Stringable $message
     * @param mixed[]           $context
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function debug($message, array $context = []): void
    {
        $this->out($message);
    }
}
