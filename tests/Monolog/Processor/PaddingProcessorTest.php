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
use Monolog\Logger;
use Monolog\LogRecord;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class PaddingProcessorTest extends TestCase
{
    use UnavailableFieldsTrait;

    protected PaddingProcessor $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PaddingProcessor();
    }

    public function testConfiguration(): void
    {
        self::assertInstanceOf(PaddingProcessor::class, $this->o2t);
        self::assertEquals(Level::Debug, $this->getFieldFromO2t('level'));
        $arrayResult = $this->getFieldFromO2t('skipClassesPartials');
        self::assertIsArray($arrayResult);
        self::assertCount(1, $arrayResult);
        self::assertStringContainsString('Monolog\\', $arrayResult[0]);
        self::assertEquals(0, $this->getFieldFromO2t('skipStackFramesCount'));
    }

    public function testInvoke(): void
    {
        $expectedCount = 7;
        $expectedKeys  = [
            'message',
            'context',
            'level',
            'level_name',
            'channel',
            'datetime',
        ];
        $expectedExtraKeys = [
            'level_name_pad',
        ];

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

        $record = new LogRecord(
            datetime: new \DateTimeImmutable(),
            channel: '',
            level: Level::Info,
            message: '',
            context: [],
            extra: [],
            formatted: ''
        );

        $result = $this->o2t->__invoke($record);

        self::assertNotEmpty($result);
        self::assertCount($expectedCount, $result->toArray());

        self::assertStringContainsString(
            $testArray['level_name'], 
            $result->offsetGet($this->o2t::OFFSET_EXTRA)[$this->o2t::OFFSET_LEVEL_NAME_PAD]
            );
        self::assertGreaterThan(
            strlen($testArray['level_name']), 
            strlen($result->offsetGet($this->o2t::OFFSET_EXTRA)[$this->o2t::OFFSET_LEVEL_NAME_PAD])
            );
        foreach ($expectedKeys as $key) {
            self::assertArrayHasKey($key, $result);
        }
        foreach ($expectedExtraKeys as $key) {
            self::assertArrayHasKey($key, $result->offsetGet($this->o2t::OFFSET_EXTRA));
        }
    }
}
