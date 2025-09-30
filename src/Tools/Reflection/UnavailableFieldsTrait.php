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
     * @return null|mixed
     */
    protected function getFieldByReflection($clazzName, string $fieldName, $instance)
    {
        $result = null;
        if (!empty($clazzName)) {
            $refObject = new ReflectionProperty($clazzName, $fieldName);
            $refObject->setAccessible(true); // NOSONAR: php:S3011

            $result = $refObject->getValue($instance);  // NOSONAR: php:S3011
        }

        return $result;
    }

    /**
     * @param string $fieldName
     *
     * @return null|mixed
     */
    protected function getFieldFromO2t(string $fieldName)
    {
        $result = null;

        /**
         * @psalm-suppress RedundantPropertyInitializationCheck
         */
        if (isset($this->o2t)) {
            $clazzName = get_class($this->o2t);
            /** @psalm-suppress RedundantCondition */
            if (!empty($clazzName)) {
                $result = $this->getFieldByReflection($clazzName, $fieldName, $this->o2t);
            }
        }

        return $result;
    }
}
