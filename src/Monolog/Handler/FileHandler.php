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

use Monolog\Level;
use Psr\Log\LogLevel;

/**
 * Class FileHandler.
 *
 * @see StreamHandler
 */
class FileHandler extends StreamHandler
{
    /** @var string Fallback filename */
    public const STANDARD_FILENAME = 'noFilename';

    /** @var string Default file extension */
    public const STANDARD_FILEEXT  = '.log';

    /** @var string Default output level (DEBUG) */
    public const LEVEL_DEFAULT =  LogLevel::DEBUG;

    /** @var string Default separator char for namespace (Default) */
    public const C_NS_SEP  = "\\";

    /** @var string Default separator char for namespace (Filesystem) */
    public const        C_NS_FS_SEP = '_';

    /** @var string Key of the message in the output record */
    protected const KEY_MESSAGE = 'message';

    /** @var string Key of the contect in the output record */
    protected const KEY_CONTEXT = 'context';

    /** @var string Temporary folder */
    private static $tmpDir;

    /** @var string The full filename (with path) of the output file */
    private $fileName;

    /**
     * @param null|string $pathToFile The full path to the output folder
     * @param null|string $fileName   The name of the output file
     *
     * @return string The full filename (with path) of the output file
     */
    public static function prepareFileName(?string $pathToFile = null, ?string $fileName = ''): string
    {
        if (is_null($pathToFile) || empty($pathToFile)) {
            $pathToFile = self::$tmpDir;
        }
        if (is_null($fileName) || empty($fileName)) {
            $fileName = static::STANDARD_FILENAME;
        }

        return $pathToFile . DIRECTORY_SEPARATOR . str_replace(self::C_NS_SEP, self::C_NS_FS_SEP, $fileName . static::STANDARD_FILEEXT);
    }

    /**
     * FileHandler constructor.
     *
     * @param null|string $pathToFile The full path to the output folder
     * @param null|string $fileName   The name of the output file
     * @param mixed       $level      The output level (Default: {@link FileHandler::LEVEL_DEFAULT})
     *
     * @see FileHandler::LEVEL_DEFAULT
     */
    public function __construct(?string $pathToFile = null, ?string $fileName = null, $level = self::LEVEL_DEFAULT)
    {
        self::$tmpDir   = sys_get_temp_dir();
        $this->fileName = static::prepareFileName($pathToFile, $fileName);
        parent::__construct($this->fileName, $level);
    }

    /**
     * @return string The full filename (with path) of the output file
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
