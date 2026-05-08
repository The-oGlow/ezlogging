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

/**
 * @SuppressWarnings("PHPMD.CamelCasePropertyName")
 * @SuppressWarnings("PHPMD.CamelCaseMethodName")
 */
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

    /** @var null|string */
    public const C_DATA_NULL = null;

    public const C_DATA_EMPTY = '';

    public const C_DATA_INVALID = 'INVALID';

    public const C_DATA_NOTEXIST = 'NOT-EXIST';

    // Array keys
    public const C_KEY_NUM1 = 1;

    public const C_KEY_NUM2 = 2;

    public const C_KEY_NUM3 = 3;

    public const C_KEY_NUM4 = 4;

    public const C_KEY_NUM5 = 5;

    public const C_KEY_ALPHA1 = 'KEY-ALPHA1';

    public const C_KEY_ALPHA2 = 'KEY-ALPHA2';

    public const C_KEY_ALPHA3 = 'KEY-ALPHA3';

    public const C_ARRAY_ITEMS_SEP = ',';

    // Arrays complete
    public const C_ARRAY_EMPTY = [];

    /** @var null|array<mixed,mixed> */
    public const C_ARRAY_NULL = null;

    public const C_ARRAY_ALPHA1 = [self::C_DATA_ALPHA1];

    public const C_ARRAY_ALPHA2 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2];

    public const C_ARRAY_ALPHA3 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3];

    public const C_ARRAY_ALPHA4 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3, self::C_DATA_ALPHA4];

    public const C_ARRAY_ALPHA5 = [self::C_DATA_ALPHA1, self::C_DATA_ALPHA2, self::C_DATA_ALPHA3, self::C_DATA_ALPHA4, self::C_DATA_ALPHA5];

    public const C_ARRAY_ALPHA_KEY1 = [self::C_KEY_ALPHA1 => self::C_DATA_ALPHA1];

    public const C_ARRAY_NUM1 = [self::C_DATA_NUM1];

    public const C_ARRAY_NUM2 = [self::C_DATA_NUM1, self::C_DATA_NUM2];

    public const C_ARRAY_BOOL1 = [self::C_DATA_BOOLT];

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
    /** @var null|string */
    public const C_FILENAME_NULL = null;

    public const C_FILENAME_EMPTY = '';

    public const C_FILENAME_PREFIX = 'teda-';

    // File Extensions

    /** @var null|string */
    public const C_EXT_NULL = null;

    public const C_EXT_EMPTY = '';

    public const C_EXT_PHP = '.php';

    public const C_EXT_TXT = '.txt';

    public const C_EXT_JSON = '.json';

    public const C_EXT_CSV = '.csv';

    /** @var array<mixed> */
    private static $C_ARRAY_OBJECT1 = [];

    /** @var array<mixed> */
    private static $C_ARRAY_OBJECT2 = [];

    /** @var array<mixed> */
    private static $C_ARRAY_OBJECT3 = [];

    public static function C_DATA_OBJECT1(): TestDataFoo
    {
        return TestDataFoo::init(TestData::C_DATA_NUM1);
    }

    /**
     * @return array<mixed>
     */
    public static function C_ARRAY_OBJECT1(): array
    {
        if (empty(self::$C_ARRAY_OBJECT1)) {
            self::$C_ARRAY_OBJECT1 = [self::C_KEY_ALPHA1 => TestDataFoo::init(self::C_DATA_NUM1)];
        }

        return self::$C_ARRAY_OBJECT1;
    }

    /**
     * @return array<mixed>
     */
    public static function C_ARRAY_OBJECT2(): array
    {
        if (empty(self::$C_ARRAY_OBJECT2)) {
            self::$C_ARRAY_OBJECT2 = [
                self::C_KEY_ALPHA1 => TestDataFoo::init(self::C_DATA_NUM1),
                self::C_KEY_ALPHA2 => TestDataFoo::init(self::C_DATA_NUM2),
            ];
        }

        return self::$C_ARRAY_OBJECT2;
    }

    /**
     * @return array<mixed>
     */
    public static function C_ARRAY_OBJECT3(): array
    {
        if (empty(self::$C_ARRAY_OBJECT3)) {
            self::$C_ARRAY_OBJECT3 = [
                self::C_KEY_ALPHA1 => TestDataFoo::init(self::C_DATA_NUM1),
                self::C_KEY_ALPHA2 => TestDataFoo::init(self::C_DATA_NUM2),
                self::C_KEY_ALPHA3 => TestDataFoo::init(self::C_DATA_NUM3),
            ];
        }

        return self::$C_ARRAY_OBJECT3;
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
