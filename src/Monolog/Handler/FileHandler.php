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

use Monolog\Logger;

class FileHandler extends StreamHandler
{
    /** @var string */
    public const STANDARD_FILENAME = 'noFilename';

    /** @var string */
    public const STANDARD_FILEEXT  = '.log';

    /** @var string */
    protected const C_NS_SEP  = "\\";

    /** @var string */
    protected const        C_NS_REPL = '_';

    protected const KEY_MESSAGE = 'message';

    protected const KEY_CONTEXT = 'context';

    /** @var string */
    private static $tmpDir;

    /** @var string */
    private $fileName;

    public static function prepareFileName(?string $pathToFile = null, ?string $fileName = ''): string
    {
        if (is_null($pathToFile) || empty($pathToFile)) {
            $pathToFile = self::$tmpDir;
        }
        if (is_null($fileName) || empty($fileName)) {
            $fileName = static::STANDARD_FILENAME;
        }

        return $pathToFile . DIRECTORY_SEPARATOR . str_replace(self::C_NS_SEP, self::C_NS_REPL, $fileName . static::STANDARD_FILEEXT);
    }

    public function __construct(?string $pathToFile = null, ?string $fileName = null)
    {
        self::$tmpDir   = sys_get_temp_dir();
        $this->fileName = self::prepareFileName($pathToFile, $fileName);
        parent::__construct($this->fileName);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
