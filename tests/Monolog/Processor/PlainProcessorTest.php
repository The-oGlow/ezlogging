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

use PHPUnit\Framework\TestCase;

class PlainProcessorTest extends TestCase
{
    /** @var PlainProcessor $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PlainProcessor();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(PlainProcessor::class, $this->o2t);
    }

    public function testInvoke(): void
    {
        $testArray = [1,2,'hello'];
        $result = $this->o2t->__invoke($testArray);
        static::assertEquals($testArray, $result);
    }
}
