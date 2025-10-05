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

trait ToStringTrait
{
    use ImplodeTrait;

    /**
     * @return mixed
     *
     * @SuppressWarnings("PHPMD.CamelCaseMethodName")
     */
    abstract protected function __toStringValues();  // NOSONAR: php:S100

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        $toString = '';
        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, '__toStringValues')) {
            $value = $this->__toStringValues();
            if (is_string($value)) {
                $toString = sprintf('%s:\'%s\'', get_class($this), $value);
            } elseif (is_scalar($value)) {
                $toString = sprintf('%s:%s', get_class($this), (string)$value);
            } elseif (is_array($value)) {
                foreach (array_keys($value) as $arrayKey) {
                    if (is_object($value[$arrayKey]) && $this == $value[$arrayKey]) {
                        $value[$arrayKey] = get_class($value[$arrayKey]);
                    }
                }
                $toString = sprintf('%s:[%s]', get_class($this), implode(',', $value));
            } elseif (is_object($value)) {
                if ($this == $value) {
                    $toString = sprintf('{%s}', print_r($value, true));
                } else {
                    $toString = sprintf('%s:{%s}', get_class($this), print_r($value, true));
                }
            }
        } else {
            $toString = sprintf('[%s:{%s}]', get_class($this), '');
        }

        return $toString;
    }

    /**
     * @inheritdoc
     */
    public function __wakeup()
    {
        throw new \BadMethodCallException("Cannot unserialize singleton");
    }
}
