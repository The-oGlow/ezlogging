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
     * @param mixed $clazzName
     * @param string $methodName
     * @param mixed  $instance
     *
     * @return mixed|null
     */
    protected function callMethodByReflection($clazzName, string $methodName, $instance)
    {
        if (!empty($clazzName))
        {
            $refObject = new \ReflectionMethod($clazzName, $methodName);
            $refObject->setAccessible(true); // NOSONAR: php:S3011

            return $refObject->invoke($instance);
        } else
        {
            return null;
        }
    }

    /**
     * Calls a hidden method on an object which shall be tested (o2t).
     *
     * @param string $methodName
     *
     * @return mixed|null
     */
    protected function callMethodOnO2t(string $methodName)
    {
        /** @psalm-suppress RedundantConditionGivenDocblockType */
        if (!empty($this->o2t)) // @phpstan-ignore empty.property,property.notFound
        {
            $locO2t = $this->o2t;
            /** @psalm-suppress TypeDoesNotContainType */
            $clazzName = get_class($locO2t) === false ? '' : get_class($locO2t); // @phpstan-ignore identical.alwaysFalse

            return $this->callMethodByReflection($clazzName, $methodName, $locO2t);
        } else
        {
            return null;
        }
    }
}
