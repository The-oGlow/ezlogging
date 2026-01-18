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

namespace ollily\Tools\String;

use PHPUnit\Framework\TestCase;

class ToStringTraitTest extends TestCase
{
    /** @var ToStringTraitTestClazz */
    protected $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ToStringTraitTestClazz();
    }

    public function testToString(): void
    {
        $result = $this->o2t->__toString();
        static::assertNotEmpty($result);
        static::assertStringContainsString(get_class($this->o2t), $result);
    }

    public function testWakeup(): void
    {
        static::expectException(\BadMethodCallException::class);
        $this->o2t->__wakeup();
    }
}
