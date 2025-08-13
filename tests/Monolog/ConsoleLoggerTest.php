<?php

namespace Monolog;

use Monolog\Handler\StreamHandler;
use PHPUnit\Framework\TestCase;
use ollily\Tools\Reflection\UnavailableMethodsTrait;

require_once __DIR__.  '/../bootstrap.php';

class ConsoleLoggerTest extends TestCase
{
    use UnavailableMethodsTrait;

    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ConsoleLogger(self::class);
    }

    public function testConfiguration()
    {
        $this::assertInstanceOf(ConsoleLogger::class, $this->o2t);
        $handlers = $this->o2t->getHandlers();
        $this::assertIsArray($handlers);
        $this::assertCount(1, $handlers);
        $this::assertInstanceOf(StreamHandler::class, $handlers[0]);
    }

    public function testGetDefaultHandler(): void
    {
        $result = $this->callMethodOnO2t('getDefaultHandler');
        $this::assertNotNull($result);
        $this::assertInstanceOf(Handler\StreamHandler::class, $result);
    }

    public function testGetDefaultProcessor(): void
    {
        $result = $this->callMethodOnO2t('getDefaultProcessor');
        $this::assertNotNull($result);
        $this::assertInstanceOf(Processor\PaddingProcessor::class, $result);
    }

    public function testGetDefaultFormatter(): void
    {
        $result = $this->callMethodOnO2t('getDefaultFormatter');
        $this::assertNotNull($result);
        $this::assertInstanceOf(Formatter\EasyGoingFormatter::class, $result);
    }
}
