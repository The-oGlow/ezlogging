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

trait UnavailableMethodsTrait
{
    /**
     * Calls hidden method (private, protected, package) without parameters by reflection.
     *
     * @param string $clazzName
     * @param string $methodName
     * @param mixed  $instance
     *
     * @return mixed
     */
    protected function callMethodByReflection(string $clazzName, string $methodName, mixed $instance): mixed
    {
        $refObject = new \ReflectionMethod($clazzName, $methodName);
        $refObject->setAccessible(true);

        return $refObject->invoke($instance);
    }

    /**
     * Calls a hidden method on an object which shall be tested (o2t).
     *
     * @param string $methodName
     *
     * @return mixed
     */
    protected function callMethodOnO2t(string $methodName): mixed
    {
        if (!empty($this->o2t)) { // @phpstan-ignore empty.property,property.notFound
            $locO2t    = $this->o2t;
            /** @psalm-suppress TypeDoesNotContainType */
            $clazzName = get_class($locO2t) === false ? '' : get_class($locO2t); // @phpstan-ignore identical.alwaysFalse

            return $this->callMethodByReflection($clazzName, $methodName, $locO2t);
        } else {
            return null;
        }
    }
}
