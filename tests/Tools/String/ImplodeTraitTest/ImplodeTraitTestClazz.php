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
/**
 * This is the test clazz which will be tested.
 *
 * @see  ImplodeTraitTestDummyClazz
 * @see  ImplodeTraitTest
 */
class ImplodeTraitTestClazz
{
    use ImplodeTrait;

    public const SEP = '#';

    /** @var array<mixed,mixed> */
    public $anydata = ['first' => 'a', 'second' => [1, 2]];

    /** @var array<mixed,mixed> */
    public $anydata2 = [];

    public function __construct()
    {
        $this->anydata2[] = new ImplodeTraitTestDummyClazz();
        $this->anydata2[] = [10 => new ImplodeTraitTestDummyClazz(), 20 => new ImplodeTraitTestDummyClazz()];
    }

    public function implode_recursiveDefault(): string
    {
        return $this->implode_recursive(self::SEP, $this->anydata);
    }

    public function implode_recursiveCustom(): string
    {
        return $this->implode_recursive(self::SEP, $this->anydata, true, true);
    }

    public function implode_recursive_ObjectCustom(): string
    {
        return $this->implode_recursive(self::SEP, $this->anydata2, true, true);
    }
}
