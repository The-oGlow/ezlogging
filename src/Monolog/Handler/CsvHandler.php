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

namespace Monolog\Handler;

use Monolog\FileLogger;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Handler\StreamHandler;
use ollily\Tools\PhpVersionTrait;
use ollily\Tools\String\ImplodeTrait;

/**
 * Stores any data (given as array) to a csv file.
 *
 * Inspired by {@see https://github.com/femtopixel/monolog-csvhandler}.
 * Original by @author Jay MOULIN <jay@femtopixel.com>
 */
class CsvHandler extends FileHandler
{
    use PhpVersionTrait;
    use ImplodeTrait;

    /** @var string */
    public const    STANDARD_FILENAME = 'noCSVName';

    /** @var string */
    public const    STANDARD_FILEEXT     = '.csv';

    public const    STANDARD_ITEM_SEP    = ';';

    public const    STANDARD_TEXT_SEP    = '"';

    public const    STANDARD_ESCAPE_CHAR = '\\';

    protected const KEY_FORMATTED        = 'formatted';

    /** @var string */
    private $itemSeparator;

    /** @var string */
    private $itemEnclosure;

    /**
     * CsvHandler constructor.
     *
     * @param string $pathToFile
     * @param string $fileName
     * @param string $itemSeparator
     * @param string $itemEnclosure
     */
    public function __construct(
        ?string $pathToFile = null,
        ?string $fileName = null,
        string $itemSeparator = self::STANDARD_ITEM_SEP,
        string $itemEnclosure = self::STANDARD_TEXT_SEP
    ) {
        parent::__construct(
            $pathToFile,
            $fileName
        );
        $this->itemSeparator = $itemSeparator;
        $this->itemEnclosure = $itemEnclosure;
    }

    /**
     * @inheritdoc
     */
    protected function streamWrite($stream, array $record): void
    {
        $output = [];
        // @phpstan-ignore isset.offset
        if (isset($record[self::KEY_MESSAGE]) && !empty($record[self::KEY_MESSAGE])) {
            array_push($output, $record[self::KEY_MESSAGE]);
        }

        // @phpstan-ignore isset.offset
        if (isset($record[self::KEY_CONTEXT]) && !empty($record[self::KEY_CONTEXT])) {
            $implodeContext = $record[self::KEY_CONTEXT];
            /**
             * @psalm-suppress RedundantCondition
             * @phpstan-ignore if.alwaysTrue
             */
            if (is_array($record[self::KEY_CONTEXT])) {
                $implodeContext = $this->array_flatten($record[self::KEY_CONTEXT]);
            }
            $output = array_merge($output, $implodeContext);
        }
        if ($this->isPhpGreater('5.5.4')) {
            fputcsv($stream, $output, $this->itemSeparator, $this->itemEnclosure, static::STANDARD_ESCAPE_CHAR);
        } else {
            fputcsv($stream, $output, $this->itemSeparator, $this->itemEnclosure);
        }
    }
}
