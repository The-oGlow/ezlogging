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

use Monolog\Level;
use Monolog\LogRecord;
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
        $record = new LogRecord(
            datetime: new \DateTimeImmutable(),
            channel: '',
            level: Level::Info,
            message: '',
            context:[],
            extra:[],
            formatted:''
        );

        $result    = $this->o2t->__invoke($record);

        self::assertEquals($record, $result);
    }

    public function testInvokeWithPlain(): void
    {
        $record = new LogRecord(
            datetime: new \DateTimeImmutable(),
            channel: '',
            level: Level::Info,
            message:'hello',
            context: [1,2]
        );

        $result    = $this->o2t->__invoke($record);

        self::assertEquals($record, $result);
    }
}
