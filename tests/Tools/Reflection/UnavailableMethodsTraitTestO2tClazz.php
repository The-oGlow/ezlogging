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

/**
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

    private function privateFunc(): string // @phpstan-ignore method.unused
    {
        return 'privateFuncValue';
    }
}

/**
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols
 */
class UnavailableMethodsTraitTestO2tClazz
{
    use UnavailableMethodsTrait;

    /** @var mixed */
    protected $o2t;

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

/**
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols
 */
class UnavailableMethodsTraitTestWrongO2tClazz
{
    use UnavailableMethodsTrait;

    /**
     * @var mixed
     *
     * @SuppressWarnings("PHPMD.UnusedPrivateField")
     *
     * @phpstan-ignore property.onlyWritten
     */
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
