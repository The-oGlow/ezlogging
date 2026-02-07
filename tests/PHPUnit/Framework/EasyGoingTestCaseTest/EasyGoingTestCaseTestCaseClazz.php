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
class EasyGoingTestCaseTestCaseClazz extends EasyGoingTestCase
{
    /**
     * @return EasyGoingTestCaseClazz
     */
    protected static function prepareO2t()
    {
        return new EasyGoingTestCaseClazz();
    }

    /**
     * @return EasyGoingTestCaseClazz
     */
    protected function getCasto2t()
    {
        return $this->o2t;
    }

    protected function isConstsCrosscheck(): bool
    {
        return true;
    }

    protected function getExpectedConstsCount(): int
    {
        return 6;
    }
    // Override the visibility for the test cases

    /**
     * @return EasyGoingTestCaseClazz
     */
    public function publicGetCastO2t()
    {
        return $this->getCasto2t();
    }

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

    public function testConsts(): void
    {
        $consts = [
            EasyGoingTestCaseClazz::TEST_CLAZZ . 'TEST_CLAZZ',
            EasyGoingTestCaseClazz::TEST_CLAZZ . 'TEST_CONST_PREFIX',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PUBLIC',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PROTECTED',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_PRIVATE',
            EasyGoingTestCaseClazz::TEST_CONST_PREFIX . '_NONE',
        ];
        static::updateActualConsts($consts);

        static::verifyConstAllExists($consts);
    }
}
