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
     * @return array<mixed>
     */
    public function provideDataToString(): array
    {
        return [
            'String'      => [
                'This is a string',
                sprintf('%s:\'%s\'', ToStringTraitTestDummyClazz::class, 'This is a string'),
                true
            ],
            'Integer'     => [
                1234,
                sprintf('%s:%s', ToStringTraitTestDummyClazz::class, '1234'),
                true
            ],
            'Array'       => [
                [12, 34],
                sprintf('%s:[%s]', ToStringTraitTestDummyClazz::class, '12,34'),
                true
            ],
            'Object'      => [
                new ToStringTraitTestDummyParentClazz(),
                sprintf(
                    '%s:{%s}',
                    ToStringTraitTestDummyClazz::class,
                    ToStringTraitTestDummyParentClazz::class . " Object\n(\n)\n"
                ),
                true
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
                true
            ]
        ];
    }
}
