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
    // Single data
    public const C_NOTEXIST_NAME = 'XXXName';

    public const C_NOTEXIST_ID = 999;

    public const C_DATA_NUM1 = 11;

    public const C_DATA_NUM2 = 22;

    public const C_DATA_NUM3 = 33;

    public const C_DATA_NUM4 = 44;

    public const C_DATA_NUM5 = 55;

    public const C_DATA_ALPHA1 = 'DATA-ALPHA11';

    public const C_DATA_ALPHA2 = 'DATA-ALPHA22';

    public const C_DATA_ALPHA3 = 'DATA-ALPHA33';

    public const C_DATA_ALPHA4 = 'DATA-ALPHA44';

    public const C_DATA_ALPHA5 = 'DATA-ALPHA55';

    public const C_DATA_BOOLT = true;

    public const C_DATA_BOOLF = false;

    /** @var string */
    public const C_DATA_NULL = null;

    public const C_DATA_EMPTY = '';

    // Array keys
    public const C_KEY_NUM1 = 1;

    public const C_KEY_NUM2 = 2;

    public const C_KEY_NUM3 = 3;

    public const C_KEY_NUM4 = 4;

    public const C_KEY_NUM5 = 5;

    public const C_KEY_ALPHA1 = 'KEY-ALPHA1';

    public const C_KEY_ALPHA2 = 'KEY-ALPHA2';

    public const C_KEY_ALPHA3 = 'KEY-ALPHA3';

    // Arrays complete
    public const C_ARRAY_EMPTY = [];

    /** @var array<mixed,mixed> */
    public const C_ARRAY_NULL = null;

    public const C_ARRAY_ALPHA1 = [self::C_DATA_ALPHA1];

    public const C_ARRAY_ALPHA2 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2];

    public const C_ARRAY_ALPHA3 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3];

    public const C_ARRAY_ALPHA4 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3, self::C_DATA_ALPHA4];

    public const C_ARRAY_ALPHA5 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3, self::C_DATA_ALPHA4, self::C_DATA_ALPHA5];

    public const C_ARRAY_ALPHA_KEY1 = [self::C_KEY_ALPHA1 => self::C_DATA_ALPHA1];

    public const C_ARRAY_ALPHA_KEY2 = [
        self::C_KEY_ALPHA1 => self::C_DATA_ALPHA1,
        self::C_KEY_ALPHA2 => self::C_DATA_ALPHA2
    ];

    public const C_ARRAY_ALPHA_KEY3 = [
        self::C_KEY_ALPHA1 => self::C_DATA_ALPHA1,
        self::C_KEY_ALPHA2 => self::C_DATA_ALPHA2,
        self::C_KEY_ALPHA3 => self::C_DATA_ALPHA3
    ];

    public const C_ARRAY_NUM_KEY1 = [self::C_KEY_NUM1 => self::C_DATA_NUM1];

    public const C_ARRAY_NUM_KEY2 = [
        self::C_KEY_NUM1 => self::C_DATA_NUM1,
        self::C_KEY_NUM2 => self::C_DATA_NUM2
    ];

    public const C_ARRAY_NUM_KEY3 = [
        self::C_KEY_NUM1 => self::C_DATA_NUM1,
        self::C_KEY_NUM2 => self::C_DATA_NUM2,
        self::C_KEY_NUM3 => self::C_DATA_NUM3
    ];

    // Filenames
    /** @var string */
    public const C_FILENAME_NULL = null;

    public const C_FILENAME_EMPTY = '';

    public const C_FILENAME_PREFIX = 'teda-';

    // File Extensions
    /** @var string */
    public const C_EXT_NULL = null;

    public const C_EXT_EMPTY = '';

    public const C_EXT_PHP = '.php';

    public const C_EXT_TXT = '.txt';

    public const C_EXT_JSON = '.json';

    public const C_EXT_CSV = '.csv';

    private static function initFoo(): \Exception
    {
        return new \Exception();
    }

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
class TestDataFoo
{
    public function __toString(): string
    {
        return "TestDataFoo";
    }
}
