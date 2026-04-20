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

class ImplodeTraitTest extends TestCase
{
    /** @var ImplodeTraitTestClazz */
    protected $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ImplodeTraitTestClazz();
    }

    public function testImplodeDefault(): void
    {
        $actual = $this->o2t->implodeDefault();
        static::assertNotEmpty($actual);
    }

    public function testImplodeCustom(): void
    {
        $actual = $this->o2t->implodeCustom();
        static::assertNotEmpty($actual);
    }

    public function testImplodeObjectCustom(): void
    {
        $actual = $this->o2t->implodeObjectCustom();
        static::assertNotEmpty($actual);
    }
}
