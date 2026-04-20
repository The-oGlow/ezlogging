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

namespace ollily\Tools\Reflection\UnavailableMethodsTraitTest;

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
