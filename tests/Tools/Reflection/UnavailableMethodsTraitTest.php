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

namespace ollily\Tools\Reflection;

require_once __DIR__ . '/../../bootstrap.php';

use PHPUnit\Framework\TestCase;

/**
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols.
 *
 * @SuppressWarnings("PHPMD.UnusedPrivateMethod")
 */
class UnavailableMethodsTraitTestHolderClazz
{
    public function publicFunc(): string
    {
        return 'publicFuncValue';
    }

    protected function protectedFunc(): string
    {
        return 'protectedFuncValue';
    }

    private function privateFunc(): string
    {
        return 'privateFuncValue';
    }
}

class UnavailableMethodsTraitTestO2tClazz
{
    use UnavailableMethodsTrait;

    /** @var mixed */
    private $o2t;

    public function __construct()
    {
        $this->o2t = new UnavailableMethodsTraitTestHolderClazz();
    }

    /**
     * @param string $methodName
     *
     * @return null|mixed
     */
    public function publicCallMethodOnO2t(string $methodName)
    {
        return $this->callMethodOnO2t($methodName);
    }

    /**
     * @param string $methodName
     *
     * @return null|mixed
     */
    public function publicCallMethodByReflection(string $methodName)
    {
        return $this->callMethodByReflection(UnavailableMethodsTraitTestHolderClazz::class, $methodName, $this->o2t);
    }
}

class UnavailableMethodsTraitTestWrongO2tClazz
{
    use UnavailableMethodsTrait;

    /** @var mixed */
    private $wrongO2t;

    public function __construct()
    {
        $this->wrongO2t = new UnavailableMethodsTraitTestHolderClazz();
    }

    /**
     * @param string $methodName
     *
     * @return null|mixed
     */
    public function publicCallMethodOnO2t(string $methodName)
    {
        return $this->callMethodOnO2t($methodName);
    }
}

class UnavailableMethodsTraitTest extends TestCase
{
    /** @var UnavailableMethodsTraitTestO2tClazz */
    private $o2t;

    /** @var string[] */
    private $methodNames = ['publicFunc', 'protectedFunc', 'privateFunc'];

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new UnavailableMethodsTraitTestO2tClazz();
    }

    public function testCallMethodByReflection(): void
    {
        foreach ($this->methodNames as $methodName) {
            static::assertEquals($methodName . 'Value', $this->o2t->publicCallMethodByReflection($methodName));
        }
    }

    public function testCallMethodOnO2t(): void
    {
        foreach ($this->methodNames as $methodName) {
            static::assertEquals($methodName . 'Value', $this->o2t->publicCallMethodOnO2t($methodName));
        }
    }

    public function testCallMethodOnO2tReturnNull(): void
    {
        /** @var UnavailableMethodsTraitTestWrongO2tClazz $o2tb */
        $o2tb = new UnavailableMethodsTraitTestWrongO2tClazz();
        foreach ($this->methodNames as $methodName) {
            static::assertNull($o2tb->publicCallMethodOnO2t($methodName));
        }
    }
}
