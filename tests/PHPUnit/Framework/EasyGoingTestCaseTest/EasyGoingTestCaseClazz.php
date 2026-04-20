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

/**
 * A simple clazz which will be tested by the test clazz.
 *
 * @see EasyGoingTestCaseTestCaseClazz
 */
class EasyGoingTestCaseClazz
{
    public const    TEST_CLAZZ                      = EasyGoingTestCaseClazz::class . '::';

    public const    TEST_CONST_PREFIX               = self::TEST_CLAZZ . 'EASYGOINGTESTCASETEXT';

    public const TEST_CONST_ARRAY = ['one', 'two'];

    public const    EASYGOINGTESTCASETEXT_PUBLIC    = 'public';

    protected const EASYGOINGTESTCASETEXT_PROTECTED = 'protected';

    private const   EASYGOINGTESTCASETEXT_PRIVATE   = 'private'; // @phpstan-ignore classConstant.unused

    public const           EASYGOINGTESTCASETEXT_NONE      = 'none';
}
