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

class ToStringTraitTest extends TestCase
{
    /** @var ToStringTraitTestClazz */
    protected $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ToStringTraitTestClazz();
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
        $actualObj = new ToStringTraitTestClazz($data);
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
                sprintf('%s:\'%s\'', ToStringTraitTestClazz::class, 'This is a string'),
                true
            ],
            'Integer'     => [
                1234,
                sprintf('%s:%s', ToStringTraitTestClazz::class, '1234'),
                true
            ],
            'Array'       => [
                [12, 34],
                sprintf('%s:[%s]', ToStringTraitTestClazz::class, '12,34'),
                true
            ],
            'Object'      => [
                new ToStringTraitTestClazz2(),
                sprintf(
                    '%s:{%s}',
                    ToStringTraitTestClazz::class,
                    ToStringTraitTestClazz2::class . " Object\n(\n)\n"
                ),
                true
            ],
            'ArrayObject' => [
                [
                    'First' => new ToStringTraitTestClazz2(),
                    '2nd'   => new ToStringTraitTestClazz3()
                ],
                sprintf(
                    '%s:[%s]',
                    ToStringTraitTestClazz::class,
                    '{' . ToStringTraitTestClazz2::class . " Object\n(\n)\n}" . ",{" . ToStringTraitTestClazz3::class . " Object\n(\n)\n}"
                ),
                true
            ]
        ];
    }
}
