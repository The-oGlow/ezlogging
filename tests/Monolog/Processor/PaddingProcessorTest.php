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
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class PaddingProcessorTest extends TestCase
{
    use UnavailableFieldsTrait;

    /** @var PaddingProcessor */
    protected $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PaddingProcessor();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(PaddingProcessor::class, $this->o2t);
        static::assertEquals(Logger::DEBUG, $this->getFieldFromO2t('level'));
        $arrayResult = $this->getFieldFromO2t('skipClassesPartials');
        static::assertIsArray($arrayResult);
        static::assertCount(1, $arrayResult);
        static::assertStringContainsString('Monolog\\', $arrayResult[0]);
        static::assertEquals(0, $this->getFieldFromO2t('skipStackFramesCount'));
    }

    public function testInvoke(): void
    {
        $expectedCount = 13;
        $expectedKeys  = [
            'message',
            'context',
            'level',
            'level_name',
            'level_name_pad',
            'channel',
            'datetime',
            'xFile',
            'xLine',
            'xClass',
            'xCallType',
            'xFunction'
        ];

        $testArray = [
            'message'        => '',
            'context'        => [],
            'level'          => Logger::INFO,
            'level_name'     => 'INFO',
            'level_name_pad' => '',
            'channel'        => '',
            'datetime'       => new \DateTimeImmutable(),
            'extra'          => []
        ];

        $arrayResult = $this->o2t->__invoke($testArray);

        static::assertNotEmpty($arrayResult);
        static::assertCount($expectedCount, $arrayResult);
        static::assertStringContainsString($testArray['level_name'], $arrayResult['level_name_pad']);
        static::assertGreaterThan(strlen($testArray['level_name']), strlen($arrayResult['level_name_pad']));
        foreach ($expectedKeys as $key) {
            static::assertArrayHasKey($key, $arrayResult);
        }
    }
}
