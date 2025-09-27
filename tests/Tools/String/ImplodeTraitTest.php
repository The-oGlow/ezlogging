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

class ImplodeTraitTest extends TestCase
{
    /** @var ImplodeTraitTestClazz */
    private $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ImplodeTraitTestClazz();
    }

    public function testImplodeDefault(): void
    {
        $actual = $this->o2t->implodeDefault();
        static::assertNotEmpty($actual);
        // @phpstan-ignore staticMethod.alreadyNarrowedType
        static::assertIsString($actual);
    }

    public function testImplodeCustom(): void
    {
        $actual = $this->o2t->implodeCustom();
        static::assertNotEmpty($actual);
        // @phpstan-ignore staticMethod.alreadyNarrowedType
        static::assertIsString($actual);
    }

    public function testImplodeObjectCustom(): void
    {
        $actual = $this->o2t->implodeObjectCustom();
        static::assertNotEmpty($actual);
        // @phpstan-ignore staticMethod.alreadyNarrowedType
        static::assertIsString($actual);
    }
}

/**
 * Class ImplodeTraitTestObject.
 *
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols.
 */
class ImplodeTraitTestObject
{
}

/**
 * Class ImplodeTraitTestClazz.
 *
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols.
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
        $this->anydata2[] = new ImplodeTraitTestObject();
        $this->anydata2[] = [10 => new ImplodeTraitTestObject(),20 => new ImplodeTraitTestObject()];
    }

    public function implodeDefault(): ?string
    {
        return $this->implodeRecursive(self::SEP, $this->anydata);
    }

    public function implodeCustom(): ?string
    {
        return $this->implodeRecursive(self::SEP, $this->anydata, true, true);
    }

    public function implodeObjectCustom(): ?string
    {
        return $this->implodeRecursive(self::SEP, $this->anydata2, true, true);
    }
}
