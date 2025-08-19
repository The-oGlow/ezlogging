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

require_once __DIR__ . '/../../bootstrap.php';

use PHPUnit\Framework\TestCase;

class UnavailableFieldsTraitTestHolderClazz
{
    public    $publicField    = 'publicFieldValue';
    protected $protectedField = 'protectedFieldValue';
    private   $privateField   = 'privateFieldValue';
}

class UnavailableFieldsTraitTestO2tClazz
{
    use UnavailableFieldsTrait;
    private $o2t;

    public function __construct()
    {
        $this->o2t = new UnavailableFieldsTraitTestHolderClazz();
    }

    public function publicGetFieldFromO2t(string $fieldName): mixed
    {
        return $this->getFieldFromO2t($fieldName);
    }

    public function publicGetFieldByReflection(string $fieldName): mixed
    {
        return $this->getFieldByReflection(UnavailableFieldsTraitTestHolderClazz::class, $fieldName, $this->o2t);
    }
}

class UnavailableFieldsTraitTestWrongO2tClazz
{
    use UnavailableFieldsTrait;
    private $WrongO2t;

    public function __construct()
    {
        $this->WrongO2t = new UnavailableFieldsTraitTestHolderClazz();
    }

    public function publicGetFieldFromO2t(string $fieldName): mixed
    {
        return $this->getFieldFromO2t($fieldName);
    }
}
class UnavailableFieldsTraitTest extends TestCase
{
    private $o2t;
    private $fieldNames = ['publicField', 'protectedField', 'privateField'];

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new UnavailableFieldsTraitTestO2tClazz();
    }

    public function testGetFieldByReflection()
    {
        foreach ($this->fieldNames as $fieldName)
        {
            static::assertEquals($fieldName . 'Value', $this->o2t->publicGetFieldByReflection($fieldName));
        }
    }

    public function testGetFieldFromO2t()
    {
        foreach ($this->fieldNames as $fieldName)
        {
            static::assertEquals($fieldName . 'Value', $this->o2t->publicGetFieldFromO2t($fieldName));
        }
    }

    public function testGetFieldFromO2tReturnNull()
    {
        $o2tb = new UnavailableFieldsTraitTestWrongO2tClazz();
        foreach ($this->fieldNames as $fieldName)
        {
            static::assertNull($o2tb->publicGetFieldFromO2t($fieldName));
        }
    }
}
