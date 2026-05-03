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

use PHPUnit\Framework\TestCase;

/**
 * This is the test clazz which will test the test clazz.
 *
 * @see ImplodeTraitTestClazz
 */
class ImplodeTraitTest extends TestCase
{
    /** @var ImplodeTraitTestClazz */
    protected $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ImplodeTraitTestClazz();
    }

    public function testImplode_recursiveDefault(): void
    {
        $actual = $this->o2t->implode_recursiveDefault();
        static::assertNotEmpty($actual);
    }

    public function testImplode_recursiveCustom(): void
    {
        $actual = $this->o2t->implode_recursiveCustom();
        static::assertNotEmpty($actual);
    }

    public function testImplode_recursiveObjectCustom(): void
    {
        $actual = $this->o2t->implode_recursive_ObjectCustom();
        static::assertNotEmpty($actual);
    }
}
