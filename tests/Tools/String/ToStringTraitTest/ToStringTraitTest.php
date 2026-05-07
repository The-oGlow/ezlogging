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

namespace ollily\Tools\String\ToStringTraitTest;

use PHPUnit\Framework\TestCase;
use ollily\Tools\TestData;
use ollily\Tools\TestDataFoo;

/**
 * This is the test clazz which will test the test clazz.
 *
 * @see ToStringTraitTestDummyClazz
 * @see ToStringTraitTestDummyParentClazz
 * @see ToStringTraitTestDummyChildClazz
 */
class ToStringTraitTest extends TestCase
{
    /** @var ToStringTraitTestDummyClazz */
    protected $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ToStringTraitTestDummyClazz();
    }

    public function testToStringDefault(): void
    {
        $result = $this->o2t->__toString();
        static::assertNotEmpty($result);
        static::assertStringContainsString(get_class($this->o2t), $result);
    }

    public function testWakeup(): void
    {
        static::expectException(\BadMethodCallException::class);
        $this->o2t->__wakeup();
    }

    /**
     * @param mixed  $data
     * @param string $expected
     *
     * @dataProvider provideDataToString
     */
    public function testToString($data, string $expected): void
    {
        $actualObj = new ToStringTraitTestDummyClazz($data);
        $actual    = $actualObj->__toString();

        static::assertEquals($expected, $actual);
    }

    /**
     * @return array<string,array<mixed>>
     */
    public function provideDataToString(): array
    {
        return [
            'String'      => [
                TestData::C_DATA_ALPHA1,
                sprintf('%s:\'%s\'', ToStringTraitTestDummyClazz::class, TestData::C_DATA_ALPHA1)
            ],
            'Integer'     => [
            TestData::C_DATA_NUM1,
                sprintf('%s:%s', ToStringTraitTestDummyClazz::class, TestData::C_DATA_NUM1),
            ],
            'Array'       => [
            TestData::C_ARRAY_ALPHA3,
                sprintf(
                    '%s:[%s]',
                    ToStringTraitTestDummyClazz::class,
                    implode(',', TestData::C_ARRAY_ALPHA3)
                ),
            ],
            'ArrayWithKeys' => [
                TestData::C_ARRAY_ALPHA_KEY2,
                sprintf(
                    '%s:[%s]',
                    ToStringTraitTestDummyClazz::class,
                    implode(',', TestData::C_ARRAY_ALPHA_KEY2)
                ),
            ],
            'ArrayWithObjectKey' => [
                [new TestDataFoo(), TestData::C_DATA_NUM1],
                sprintf(
                    '%s:[%s]',
                    ToStringTraitTestDummyClazz::class,
                    implode(',', [new TestDataFoo(), TestData::C_DATA_NUM1])
                ),
            ],
            'Object'      => [
                new ToStringTraitTestDummyParentClazz(),
                sprintf(
                    '%s:{%s}',
                    ToStringTraitTestDummyClazz::class,
                    ToStringTraitTestDummyParentClazz::class . " Object\n(\n)\n"
                ),
            ],
            'ArrayObject' => [
                [
                    'First' => new ToStringTraitTestDummyParentClazz(),
                    '2nd'   => new ToStringTraitTestDummyChildClazz()
                ],
                sprintf(
                    '%s:[%s]',
                    ToStringTraitTestDummyClazz::class,
                    '{' . ToStringTraitTestDummyParentClazz::class . " Object\n(\n)\n}" . ",{" . ToStringTraitTestDummyChildClazz::class . " Object\n(\n)\n}"
                ),
            ]
        ];
    }
}
