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

namespace ollily\Tools\String\ImplodeTraitTest;

use ollily\Tools\String\ImplodeTrait;
use ollily\Tools\TestData;

/**
 * This is the test clazz which will be tested.
 *
 * @see  ImplodeTraitTest
 */
class ImplodeTraitTestDummyClazz
{
    use ImplodeTrait;

    /** @var array<mixed,mixed> */
    public $traitData = TestData::C_ARRAY_ALPHA2;

    /** @var array<mixed,mixed> */
    public $traitObject = TestData::C_ARRAY_EMPTY;

    public function __construct()
    {
        $this->traitObject[] = new ImplodeTraitTestFooClazz();
        $this->traitObject[] = [
            TestData::C_KEY_NUM1 => new ImplodeTraitTestFooClazz(),
            TestData::C_KEY_NUM2 => new ImplodeTraitTestFooClazz()
        ];
    }
}
