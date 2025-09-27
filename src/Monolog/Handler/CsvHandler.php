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

/**
 * Stores any data (given as array) to a csv file.
 *
 * Inspired by {@see https://github.com/femtopixel/monolog-csvhandler}.
 * Original by @author Jay MOULIN <jay@femtopixel.com>
 */
class CsvHandler extends FileHandler
{
    use PhpVersionTrait;

    public const    STANDARD_FILENAME = 'noCSVName';

    public const    STANDARD_FILEEXT  = '.csv';

    public const    ITEM_SEP          = ';';

    public const    TEXT_SEP          = '"';

    public const    ESCAPE_CHAR       = '\\';

    protected const KEY_FORMATTED     = 'formatted';

    /** @var string  */
    private $itemSeparator;

    /** @var string  */
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
        string $itemSeparator = self::ITEM_SEP,
        string $itemEnclosure = self::TEXT_SEP
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
        if (is_array($record[self::KEY_FORMATTED])) {
            foreach ($record[self::KEY_FORMATTED] as $key => $info) {
                if (is_array($info)) {
                    $record[self::KEY_FORMATTED][$key] = json_encode($info);
                }
            }
        }
        $formatted = (array)$record[self::KEY_FORMATTED];
        if ($this->isPhpGreater('5.5.4')) {
            fputcsv($stream, $formatted, $this->itemSeparator, $this->itemEnclosure, static::ESCAPE_CHAR);
        } else {
            fputcsv($stream, $formatted, $this->itemSeparator, $this->itemEnclosure);
        }
    }
}
