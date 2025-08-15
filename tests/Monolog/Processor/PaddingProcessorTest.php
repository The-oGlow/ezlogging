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

    /** @var PaddingProcessor $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PaddingProcessor();
    }

    public function testConfiguration(): void
    {
        $this::assertInstanceOf(PaddingProcessor::class, $this->o2t);
        $this::assertEquals(Logger::DEBUG, $this->getFieldFromO2t('level'));
        $arrayResult = $this->getFieldFromO2t('skipClassesPartials');
        $this::assertIsArray($arrayResult);
        $this::assertCount(1, $arrayResult);
        $this::assertStringContainsString('Monolog\\', $arrayResult[0]);
        $this::assertEquals(0, $this->getFieldFromO2t('skipStackFramesCount'));
    }

    public function testInvoke(): void
    {
        $testArray = ['level' => Logger::INFO, 'level_name' => 'INFO'];
        $testArrayKeys = ['level','level_name', 'level_name_pad', 'xFile', 'xLine', 'xClass', 'xCallType', 'xFunction'];

        $arrayResult = $this->o2t->__invoke($testArray);

        $this::assertNotEmpty($arrayResult);
        $this::assertCount(8, $arrayResult);
        $this::assertStringContainsString($testArray['level_name'], $arrayResult['level_name_pad']);
        $this::assertGreaterThan(strlen($testArray['level_name']), strlen($arrayResult['level_name_pad']));
        foreach ($testArrayKeys as $key) {
            $this::assertArrayHasKey($key, $arrayResult);
        }
    }
}
