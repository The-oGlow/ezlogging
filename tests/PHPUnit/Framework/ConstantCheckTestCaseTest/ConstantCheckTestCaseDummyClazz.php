<?php
/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 29.04.2026
 * Time: 11:34
 */

namespace PHPUnit\Framework\ConstantCheckTestCaseTest;

use PHPUnit\Framework\EasyGoingTestCaseTest\EasyGoingTestCaseDummyClazz;

/**
 * A simple clazz which will be tested by the test clazz.
 *
 * @see ConstantCheckTestCaseClazz
 */
class ConstantCheckTestCaseDummyClazz
{
    public const    TEST_CLAZZ                               = self::class . '::';
    public const    TEST_CONST_PREFIX                        = self::TEST_CLAZZ . 'TEST_CONST';
    public const    TEST_CONST_ARRAY                         = ['one', 'two'];
    public const    TEST_CONST_PUBLIC    = 'public';
    protected const TEST_CONST_PROTECTED = 'protected';
    private const   TEST_CONST_PRIVATE   = 'private'; // @phpstan-ignore classConstant.unused
}