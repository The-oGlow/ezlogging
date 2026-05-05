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

namespace ollily\Tools\Batch;

use PHPUnit\Framework\EasyGoingTestCase;
use ollily\Tools\TestData;

class TaskItemTest extends EasyGoingTestCase
{
    public const KEY = TestData::C_KEY_NUM;

    public const DATA = [TestData::C_DATA_ALPHA, TestData::C_DATA_BOOL];

    /**
     * @return ITaskItem
     */
    protected static function prepareO2t()
    {
        return new TaskItem(self::KEY, self::DATA);
    }

    /**
     * @return ITaskItem
     */
    protected function getCasto2t()
    {
        return $this->o2t;
    }

    public function testInstance(): void
    {
        $expected = ITaskItem::class;

        $actual = $this->getCasto2t();

        static::assertInstanceOf($expected, $actual);
    }

    public function testGetKey(): void
    {
        $expected = self::KEY;

        $actual = $this->getCasto2t()->getKey();

        static::assertEquals($expected, $actual);
    }

    public function testGetData(): void
    {
        $expected = self::DATA;

        $actual = $this->getCasto2t()->getData();

        static::assertEquals($expected, $actual);
    }
}
