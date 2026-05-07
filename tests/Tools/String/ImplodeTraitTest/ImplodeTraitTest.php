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

namespace ollily\Tools\String\ImplodeTraitTest;

use PHPUnit\Framework\TestCase;

/**
 * This is the test clazz which will test the test clazz.
 *
 * @see ImplodeTraitTestDummyClazz
 */
class ImplodeTraitTest extends TestCase
{
    public const ITEM_SEP = '#';

    public const KEY_SEP = '=>';

    /** @var ImplodeTraitTestDummyClazz */
    protected $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ImplodeTraitTestDummyClazz();
    }

    public function testImplode_recursiveDefault(): void
    {
        $testData = $this->o2t->traitData;
        $expectedKeyCount = 0;
        $expectedItemCount = count($testData) - 1;

        $actual = $this->o2t->implode_recursive(self::ITEM_SEP, $testData);

        $this->verifyResult($actual, $testData, $expectedKeyCount, $expectedItemCount);
    }

    public function testImplode_recursiveCustom(): void
    {
        $testData = $this->o2t->traitData;
        $expectedKeyCount = count($testData);
        $expectedItemCount = $expectedKeyCount - 1;

        $actual = $this->o2t->implode_recursive(self::ITEM_SEP, $testData, true, true);

        $this->verifyResult($actual, $testData, $expectedKeyCount, $expectedItemCount);
    }

    public function testImplode_recursive_ObjectCustom(): void
    {
        $testData = $this->o2t->traitObject;
        $expectedKeyCount = count($testData) + count($testData[1]);
        $expectedItemCount = $expectedKeyCount - 2;

        $actual = $this->o2t->implode_recursive(self::ITEM_SEP, $testData, true, true);

        $this->verifyResult($actual, $testData, $expectedKeyCount, $expectedItemCount, true);
    }

    /**
     * @param mixed $actual
     * @param mixed $testData
     * @param int   $expectedKeyCount
     * @param int   $expectedItemCount
     * @param bool  $withClazz
     */
    public function verifyResult($actual, $testData, int $expectedKeyCount, int $expectedItemCount, bool $withClazz = false): void
    {
        static::assertNotEmpty($actual);
        static::assertEquals($expectedKeyCount, substr_count($actual, self::KEY_SEP));
        static::assertEquals($expectedItemCount, substr_count($actual, self::ITEM_SEP));
        foreach ($testData as $expected) {
            if ($withClazz) {
                if (is_array($expected)) {
                    foreach ($expected as $innerExpected) {
                        static::assertStringContainsString('' . get_class($innerExpected), $actual);
                    }
                } else {
                    static::assertStringContainsString('' . get_class($expected), $actual);
                }
            } else {
                static::assertStringContainsString($expected, $actual);
            }
        }
    }
}
