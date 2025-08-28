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

/**
 * phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses,PSR1.Files.SideEffects.FoundWithSymbols
 */
class UnavailableFieldsTraitTestHolderClazz
{
    /** @var string $publicField */
    public $publicField = 'publicFieldValue';

    /** @var string $protectedField */
    protected $protectedField = 'protectedFieldValue';

    /** @var string $privateField */
    private $privateField = 'privateFieldValue';
}

class UnavailableFieldsTraitTestO2tClazz
{
    use UnavailableFieldsTrait;

    /** @var mixed $o2t */
    private $o2t;

    public function __construct()
    {
        $this->o2t = new UnavailableFieldsTraitTestHolderClazz();
    }

    /**
     * @param string $fieldName
     *
     * @return mixed|null
     */
    public function publicGetFieldFromO2t(string $fieldName)
    {
        return $this->getFieldFromO2t($fieldName);
    }

    /**
     * @param string $fieldName
     *
     * @return mixed|null
     */
    public function publicGetFieldByReflection(string $fieldName)
    {
        return $this->getFieldByReflection(UnavailableFieldsTraitTestHolderClazz::class, $fieldName, $this->o2t);
    }
}

class UnavailableFieldsTraitTestWrongO2tClazz
{
    use UnavailableFieldsTrait;

    /** @var mixed $wrongO2t */
    private $wrongO2t;

    public function __construct()
    {
        $this->wrongO2t = new UnavailableFieldsTraitTestHolderClazz();
    }

    /**
     * @param string $fieldName
     *
     * @return mixed|null
     */
    public function publicGetFieldFromO2t(string $fieldName)
    {
        return $this->getFieldFromO2t($fieldName);
    }
}

class UnavailableFieldsTraitTest extends TestCase
{
    /** @var UnavailableFieldsTraitTestO2tClazz $o2t */
    private $o2t;

    /** @var string[] */
    private $fieldNames = ['publicField', 'protectedField', 'privateField'];

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new UnavailableFieldsTraitTestO2tClazz();
    }

    public function testGetFieldByReflection(): void
    {
        foreach ($this->fieldNames as $fieldName) {
            static::assertEquals($fieldName . 'Value', $this->o2t->publicGetFieldByReflection($fieldName));
        }
    }

    public function testGetFieldFromO2t(): void
    {
        foreach ($this->fieldNames as $fieldName) {
            static::assertEquals($fieldName . 'Value', $this->o2t->publicGetFieldFromO2t($fieldName));
        }
    }

    public function testGetFieldFromO2tReturnNull(): void
    {
        /** @var UnavailableFieldsTraitTestWrongO2tClazz $o2tb */
        $o2tb = new UnavailableFieldsTraitTestWrongO2tClazz();
        foreach ($this->fieldNames as $fieldName) {
            static::assertNull($o2tb->publicGetFieldFromO2t($fieldName));
        }
    }
}
