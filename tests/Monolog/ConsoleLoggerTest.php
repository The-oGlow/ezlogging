<?php

namespace Monolog;

use PHPUnit\Framework\TestCase;

class ConsoleLoggerTest extends TestCase
{
    use \ollily\ReflectionTrait;
    protected ConsoleLogger $o2t;

    protected function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ConsoleLogger(self::class);
    }

    public function testGetDefaultHandler(): void
    {
        $result = $this->callMethodOnO2t("getDefaultHandler");
        $this::assertNotNull($result);
        $this::assertInstanceOf(Handler\StreamHandler::class, $result);

    }

    public function testGetDefaultProcessor(): void
    {
        $result = $this->callMethodOnO2t("getDefaultProcessor");
        $this::assertNotNull($result);
        $this::assertInstanceOf(Processor\PaddingProcessor::class, $result);
    }

    public function testGetDefaultFormatter(): void
    {
        $result = $this->callMethodOnO2t("getDefaultFormatter");
        $this::assertNotNull($result);
        $this::assertInstanceOf(Formatter\EasyGoingFormatter::class, $result);
    }
}
