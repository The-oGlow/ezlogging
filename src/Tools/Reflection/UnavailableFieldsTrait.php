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

use ReflectionProperty;

trait UnavailableFieldsTrait
{
    protected function getFieldByReflection(string $clazzName, string $fieldName, mixed $instance): mixed
    {
        $refObject = new ReflectionProperty($clazzName, $fieldName);
        return $refObject->getValue($instance);
    }

    protected function getFieldFromO2t(string $fieldName): mixed
    {

        $_o2t = null;
        // @phpstan-ignore empty.property
        if (!empty($this->o2t)) {
            $_o2t = $this->o2t;
            return  $this->getFieldByReflection($_o2t::class, $fieldName, $_o2t);
        } else {
            return null;
        }
    }
}
