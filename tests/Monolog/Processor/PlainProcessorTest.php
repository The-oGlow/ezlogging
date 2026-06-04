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

namespace Monolog\Processor;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class PlainProcessorTest extends TestCase
{
    protected PlainProcessor $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PlainProcessor();
    }

    public function testConfiguration(): void
    {
        self::assertInstanceOf(PlainProcessor::class, $this->o2t);
    }

    public function testInvokeWithRecord(): void
    {
        $testArray = [
            'message'        => '',
            'context'        => [],
            'level'          => Logger::INFO,
            'level_name'     => 'INFO',
            'level_name_pad' => '',
            'channel'        => '',
            'datetime'       => new \DateTimeImmutable(),
            'extra'          => [],
        ];

        $result    = $this->o2t->__invoke($testArray);

        self::assertEquals($testArray, $result);
    }

    public function testInvokeWithPlain(): void
    {
        $testArray = [1, 2, 'hello'];

        $result    = $this->o2t->__invoke($testArray);

        self::assertEquals($testArray, $result);
    }
}
