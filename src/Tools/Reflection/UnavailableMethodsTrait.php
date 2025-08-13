<?php

declare(strict_types=1);

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
        $_o2t = null;
        if (!empty($this->o2t)) {
            $_o2t = $this->o2t;
            return $this->callMethodByReflection($_o2t::class, $methodName, $_o2t);
        } else {
            return null;
        }
    }
}
