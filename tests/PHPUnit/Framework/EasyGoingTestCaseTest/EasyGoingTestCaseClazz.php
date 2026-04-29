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
 * @see  EasyGoingTestCaseDummyClazz
 * @see  EasyGoingTestCaseTest
 */
class EasyGoingTestCaseClazz extends EasyGoingTestCase // NOSONAR: php:S3360
{
    public static function tearDownAfterClass(): void
    {
        // Deactivate the check, will be called manually in testcase
    }

    /**
     * @return EasyGoingTestCaseDummyClazz
     */
    protected static function prepareO2t()
    {
        return new EasyGoingTestCaseDummyClazz();
    }

    /**
     * @return EasyGoingTestCaseDummyClazz
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
     * @return EasyGoingTestCaseDummyClazz
     */
    public function publicGetCastO2t()
    {
        return $this->getCasto2t();
    }

    // Misc functions

    /**
     * @return mixed[]
     */
    public static function prepareAllConsts(): array
    {
        return [
            EasyGoingTestCaseDummyClazz::TEST_CLAZZ . 'TEST_CLAZZ',
            EasyGoingTestCaseDummyClazz::TEST_CLAZZ . 'TEST_CONST_PREFIX',
            EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_ARRAY',
            EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PUBLIC',
            EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PROTECTED',
            EasyGoingTestCaseDummyClazz::TEST_CONST_PREFIX . '_PRIVATE',
        ];
    }

}
