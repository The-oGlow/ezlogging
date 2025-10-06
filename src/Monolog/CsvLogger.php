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

/**
 * Class CsvLogger.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CsvLogger extends FileLogger
{
    /** @var string */
    private $itemSeparator;

    /** @var string */
    private $itemEnclosure;

    /** @var array<string> */
    private $header;

    /**
     * CsvLogger constructor.
     *
     * @param string        $name
     * @param string        $pathToFile
     * @param array<string> $header
     * @param string        $itemSeparator
     * @param string        $itemEnclosure
     */
    public function __construct(
        string $name,
        string $pathToFile,
        array $header = [],
        string $itemSeparator = CsvHandler::STANDARD_ITEM_SEP,
        string $itemEnclosure = CsvHandler::STANDARD_TEXT_SEP
    ) {
        $this->itemSeparator = $itemSeparator;
        $this->itemEnclosure = $itemEnclosure;
        $this->header        = $header;
        parent::__construct($name, $pathToFile, [], [], null);
        $this->writeHeader($this->header);
    }

    /**
     * @param string             $message
     * @param array<mixed>|mixed ...$context
     */
    public function out(string $message, ...$context): void
    {
        /**
         * @psalm-suppress TypeDoesNotContainType
         * @phpstan-ignore function.alreadyNarrowedType
         */
        if (!is_array($context)) {
            parent::info($message, [$context]);
        } else {
            parent::info($message, $context);
        }
    }

    /**
     * @param array<string> $header
     */
    protected function writeHeader(array $header): void
    {
        if (!empty($header)) {
            $this->out('', $header);
        }
    }

    /**
     * @return string
     */
    public function getItemSeparator(): string
    {
        return $this->itemSeparator;
    }

    /**
     * @return string
     */
    public function getItemEnclosure(): string
    {
        return $this->itemEnclosure;
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
}
