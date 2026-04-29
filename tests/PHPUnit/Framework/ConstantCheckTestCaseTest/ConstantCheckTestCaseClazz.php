<?php
/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 29.04.2026
 * Time: 11:35
 */

namespace PHPUnit\Framework\ConstantCheckTestCaseTest;

use PHPUnit\Framework\ConstantCheckTestCase;
use PHPUnit\Framework\EasyGoingTestCaseTest\EasyGoingTestCaseClazz;

/**
 * This is the test clazz which will be tested.
 *
 * @see  ConstantCheckTestCaseDummyClazz
 * @see  ConstantCheckTestCase
 */
class ConstantCheckTestCaseClazz extends ConstantCheckTestCase
{
    public static function tearDownAfterClass(): void
    {
        // Deactivate the check, will be called manually in testcase
    }

    /**
     * @return ConstantCheckTestCaseDummyClazz
     */
    protected static function prepareO2t()
    {
        return new ConstantCheckTestCaseDummyClazz();
    }

    /**
     * @return ConstantCheckTestCaseDummyClazz
     */
    protected function getCasto2t()
    {
        return $this->o2t;
    }

    // Override the visibility for the test cases

    /**
     * @param null|mixed[] $checkedConsts
     */
    public static function publicUpdateActualConsts($checkedConsts): void
    {
        parent::updateActualConsts($checkedConsts);
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

    // Test functions

    /**
     * Verify, if the test class has the correct constants
     */
    public function testConsts(): void
    {
        $consts = self::prepareAllConsts();
        static::updateActualConsts($consts);

        static::verifyConstAllExists($consts);
    }

    // Misc functions

    /**
     * @return mixed[]
     */
    public static function prepareAllConsts(): array
    {
        return [
            ConstantCheckTestCaseDummyClazz::TEST_CLAZZ . 'TEST_CLAZZ',
            ConstantCheckTestCaseDummyClazz::TEST_CLAZZ . 'TEST_CONST_PREFIX',
            ConstantCheckTestCaseDummyClazz::TEST_CONST_PREFIX . '_ARRAY',
            ConstantCheckTestCaseDummyClazz::TEST_CONST_PREFIX . '_PUBLIC',
            ConstantCheckTestCaseDummyClazz::TEST_CONST_PREFIX . '_PROTECTED',
            ConstantCheckTestCaseDummyClazz::TEST_CONST_PREFIX . '_PRIVATE',
        ];
    }


}