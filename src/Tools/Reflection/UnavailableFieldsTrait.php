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
    /**
     * @param mixed  $clazzName
     * @param string $fieldName
     * @param mixed  $instance
     *
     * @return mixed|null
     *
     * @SuppressWarnings("PHPMD.ElseExpression")
     */
    protected function getFieldByReflection($clazzName, string $fieldName, $instance)
    {
        if (!empty($clazzName)) {
            $refObject = new ReflectionProperty($clazzName, $fieldName);
            $refObject->setAccessible(true); // NOSONAR: php:S3011

            return $refObject->getValue($instance);  // NOSONAR: php:S3011
        } else {
            return null;
        }
    }

    /**
     * @param string $fieldName
     *
     * @return mixed|null
     *
     * @SuppressWarnings("PHPMD.ElseExpression")
     */
    protected function getFieldFromO2t(string $fieldName)
    {
        /** @psalm-suppress RedundantConditionGivenDocblockType */
        if (!empty($this->o2t)) { // @phpstan-ignore empty.property,property.notFound
            $locO2t = $this->o2t;
            /** @psalm-suppress TypeDoesNotContainType */
            $clazzName = get_class($locO2t) === false ? '' : get_class($locO2t); // @phpstan-ignore identical.alwaysFalse

            return $this->getFieldByReflection($clazzName, $fieldName, $locO2t);
        } else {
            return null;
        }
    }
}
