<?php

/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 13.08.2025
 * Time: 16:54
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
        if (!empty($this->o2t)) {
            $_o2t = $this->o2t;
            return  $this->getFieldByReflection($_o2t::class, $fieldName, $_o2t);
        } else {
            return null;
        }
    }
}
