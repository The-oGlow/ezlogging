<?php

/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 13.08.2025
 * Time: 17:27
 */

namespace Monolog\Processor;

use PHPUnit\Framework\TestCase;

class PlainProcessorTest extends TestCase
{
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PlainProcessor();
    }

    public function testConfiguration(): void
    {
        $this::assertInstanceOf(PlainProcessor::class, $this->o2t);
    }

    public function testInvoke()
    {
        $testArray = [1,2,'hello'];
        $result = $this->o2t->__invoke($testArray);
        $this::assertEquals($testArray, $result);
    }
}
