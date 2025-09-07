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

use oglowa\tools\Yacorapi\Helper\ImplodeTrait;

trait ToStringTrait
{
    use ImplodeTrait;

    /**
     * @return mixed[]
     */
    abstract protected function __toStringValues(): array;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return sprintf('[{%s}:{%s}]', get_class($this), $this->arrayRecImplode(',', $this->__toStringValues(), true));
    }

    /**
     * @inheritdoc
     */
    public function __wakeup()
    {
        throw new \BadMethodCallException("Cannot unserialize singleton");
    }

    /**
     * @inheritdoc
     */
    private function __clone()
    {
    }
}
