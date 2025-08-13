<?php

declare(strict_types=1);

namespace ollily;

trait ReflectionTrait
{
    function callByReflection(string $class, string $method, mixed $obj): mixed
    {
        $refObject = new \ReflectionMethod($class, $method);
        $refObject->setAccessible(true);
        return $refObject->invoke($obj);
    }

    function callMethodOnO2t(string $method): mixed
    {
        return $this->callByReflection($this->o2t::class, $method, $this->o2t);
    }
}
