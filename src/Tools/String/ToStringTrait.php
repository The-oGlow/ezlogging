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
     * @return mixed[]
     *
     * @SuppressWarnings("PHPMD.CamelCaseMethodName")
     */
    abstract protected function __toStringValues(): array;  // NOSONAR: php:S100

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, '__toStringValues')) {
            $toString = sprintf('[%s:{%s}]', get_class($this), $this->implode_recursive(',', $this->__toStringValues(), false, true));
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
