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
    public const STANDARD_FILENAME = 'noFilename';
    public const STANDARD_FILEEXT  = '.log';

    /** @var string $tmpDir */
    private static $tmpDir;
    /** @var string $fileName */
    private $fileName;

    public static function prepareFileName(?string $pathToFile = null, ?string $fileName = ''): string
    {
        if (empty($pathToFile)) {
            $pathToFile = self::$tmpDir;
        }
        if (empty($fileName)) {
            $fileName = self::STANDARD_FILENAME;
        }
        return $pathToFile . DIRECTORY_SEPARATOR . str_replace("\\", "_", $fileName . self::STANDARD_FILEEXT);
    }

    public function __construct(?string $pathToFile = null, ?string $fileName = null)
    {
        self::$tmpDir = sys_get_temp_dir();
        $this->fileName = $this::prepareFileName($pathToFile, $fileName);
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
