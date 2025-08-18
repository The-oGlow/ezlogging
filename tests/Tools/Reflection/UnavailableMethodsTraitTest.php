<?php
/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 18.08.2025
 * Time: 20:04
 */

namespace ollily\Tools\Reflection;

require_once __DIR__ . '/../../bootstrap.php';

use PHPUnit\Framework\TestCase;

class UnavailableMethodsTraitTestHolderClazz
{
    public function publicFunc(): string
    {
        return 'publicFuncValue';
    }

    protected function protectedFunc(): string
    {
        return 'protectedFuncValue';
    }

    private function privateFunc(): string
    {
        return 'privateFuncValue';
    }
}

class UnavailableMethodsTraitTestO2tClazz
{
    use UnavailableMethodsTrait;
    private $o2t;

    public function __construct()
    {
        $this->o2t = new UnavailableMethodsTraitTestHolderClazz();
    }

    public function publicCallMethodOnO2t(string $methodName): mixed
    {
        return $this->callMethodOnO2t($methodName);
    }

    public function publicCallMethodByReflection(string $methodName): mixed
    {
        return $this->callMethodByReflection(UnavailableMethodsTraitTestHolderClazz::class, $methodName, $this->o2t);
    }
}

class UnavailableMethodsTraitTestWrongO2tClazz
{
    use UnavailableMethodsTrait;
    private $WrongO2t;

    public function __construct()
    {
        $this->WrongO2t = new UnavailableMethodsTraitTestHolderClazz();
    }

    public function publicCallMethodOnO2t(string $methodName): mixed
    {
        return $this->callMethodOnO2t($methodName);
    }
}

class UnavailableMethodsTraitTest extends TestCase
{
    private $o2t;
    private $methodNames = ['publicFunc', 'protectedFunc', 'privateFunc'];

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new UnavailableMethodsTraitTestO2tClazz();
    }

    public function testCallMethodByReflection()
    {
        foreach ($this->methodNames as $methodName)
        {
            static::assertEquals($methodName . 'Value', $this->o2t->publicCallMethodByReflection($methodName));
        }
    }

    public function testCallMethodOnO2t()
    {
        foreach ($this->methodNames as $methodName)
        {
            static::assertEquals($methodName . 'Value', $this->o2t->publicCallMethodOnO2t($methodName));
        }
    }

    public function testCallMethodOnO2tReturnNull()
    {
        $o2tb = new UnavailableMethodsTraitTestWrongO2tClazz();
        foreach ($this->methodNames as $methodName)
        {
            static::assertNull($o2tb->publicCallMethodOnO2t($methodName));
        }
    }
}
