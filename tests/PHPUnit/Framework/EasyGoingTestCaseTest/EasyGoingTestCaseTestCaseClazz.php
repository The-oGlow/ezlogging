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

namespace PHPUnit\Framework\EasyGoingTestCaseTest;

use PHPUnit\Framework\EasyGoingTestCase;
use PHPUnit\Framework\EasyGoingTestCaseTest;

/**
 * This is the test clazz which will be tested.
 *
 * @see  EasyGoingTestCaseClazz
 * @see  EasyGoingTestCaseTest
 */
class EasyGoingTestCaseTestCaseClazz extends EasyGoingTestCase // NOSONAR: php:S3360
{
    /**
     * @return EasyGoingTestCaseClazz
     */
    protected static function prepareO2t()
    {
        return new EasyGoingTestCaseClazz();
    }

    public static function tearDownAfterClass(): void
    {
        // Deactivate the check
    }

    /**
     * @return EasyGoingTestCaseClazz
     */
    protected function getCasto2t()
    {
        return $this->o2t;
    }

    // Override the visibility for the test cases

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return mixed
     */
    public static function publicGetConstValue($clazz, string $constantName)
    {
        return parent::getConstValue($clazz, $constantName);
    }

    /**
     * @param mixed  $clazz
     * @param string $constantName
     *
     * @return bool
     */
    public static function publicIsConstExist($clazz, string $constantName): bool
    {
        return parent::isConstExist($clazz, $constantName);
    }

    /**
     * @param null|mixed[] $checkedConsts
     */
    public static function publicUpdateActualConsts($checkedConsts): void
    {
        parent::updateActualConsts($checkedConsts);
    }

    /**
     * @return EasyGoingTestCaseClazz
     */
    public function publicGetCastO2t()
    {
        return $this->getCasto2t();
    }

    /**
     * @param mixed[] $constants
     */
    public function publicVerifyConstAllExists(array $constants = []): void
    {
        parent::verifyConstAllExists($constants);
    }

    /**
     * @param mixed[] $constants
     */
    public function publicVerifyConstArrayAllExists(array $constants = []): void
    {
        parent::verifyConstArrayAllExists($constants);
    }

    /**
     * @param string $constantName
     * @param int    $expectedSize
     */
    public function publicVerifyConstArraySize(string $constantName, int $expectedSize): void
    {
        parent::verifyConstArraySize($constantName, $expectedSize);
    }

    /**
     * @param mixed $clazz
     * @param mixed $actualConstants
     */
    public function publicCrossCheckConstants($clazz, $actualConstants): void
    {
        parent::crossCheckConstants($clazz, $actualConstants);
    }

    // Verify, if the test class has the correct constants

    /**
     * @return mixed[]
     */
    protected static function prepareAllConsts(): array
    {
        return [
            EasyGoingTestCaseClazz::TEST_CLAZZ . 'TEST_CLAZZ',
            EasyGoingTestCaseClazz::TEST_CLAZZ . 'TEST_CONST_PREFIX',
            EasyGoingTestCaseClazz::TEST_CLAZZ . 'TEST_CONST_ARRAY',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PUBLIC',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PROTECTED',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PRIVATE',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_NONE',
        ];
    }

    public function testConsts(): void
    {
        $consts = self::prepareAllConsts();
        static::updateActualConsts($consts);

        static::verifyConstAllExists($consts);
    }
}
