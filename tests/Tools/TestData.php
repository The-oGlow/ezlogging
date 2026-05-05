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

namespace ollily\Tools;

class TestData
{
    // Unspecific test data

    public const C_NOTEXIST_NAME = 'XXXName';

    public const C_NOTEXIST_ID = 999;

    public const C_KEY_NUM = 1;

    public const C_KEY_ALPHA = 'KEY-ALPHA';

    public const C_DATA_NUM = 10;

    public const C_DATA_ALPHA = 'DATA-ABC';

    public const C_DATA_BOOL = true;

    public const C_DATA_NULL = null;

    public const C_FILENAME_EMPTY = '';

    public const C_FILENAME_PREFIX = 'teda-';

    public const C_EXT_PHP = '.php';

    public const C_EXT_CSV = '.csv';

    private function __construct()
    {
    }

    // Misc Functions

    /**
     * @param string $prefix a prefix for the filename
     *
     * @return string full filename for a temporary file
     *
     * @see TestData::C_FILENAME_PREFIX
     */
    public static function prepareTempFile(string $prefix = self::C_FILENAME_PREFIX): string
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    /**
     * @param string $fileName full filename for a temporary file
     */
    public static function cleanupTempFile(string $fileName): void
    {
        try {
            if (!empty($fileName) && file_exists($fileName)) {
                unlink($fileName);
            }
        } catch (\Throwable $ex) {
            echo "\n[WARNING] $ex";
        }
    }
}
