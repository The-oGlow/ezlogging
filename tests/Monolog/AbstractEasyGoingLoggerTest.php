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

namespace Monolog;

require_once __DIR__ . '/../bootstrap.php';

use DateTimeZone;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\ConsoleHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\ProcessorInterface;
use PHPUnit\Framework\TestCase;

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses, PSR1.Files.SideEffects.FoundWithSymbols
class AbstractEasyGoingLoggerTestHandlerClazz implements HandlerInterface //NOSONAR php:S3360
{
    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function isHandling(array $record): bool
    {
        return true;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function handle(array $record): bool
    {
        return true;
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    public function handleBatch(array $records): void
    {
        // nothing2do
    }

    public function close(): void
    {
        // nothing2do
    }
}

class AbstractEasyGoingLoggerTestProcessorClazz implements ProcessorInterface //NOSONAR php:S3360
{
    public function __invoke(array $record)
    {
        return $record;
    }
}

class AbstractEasyGoingLoggerTestFormatterClazz implements FormatterInterface //NOSONAR php:S3360
{
    public function format(array $record)
    {
        return $record;
    }

    public function formatBatch(array $records)
    {
        return $records;
    }
}

class AbstractEasyGoingLoggerTestClazz extends AbstractEasyGoingLogger //NOSONAR php:S3360
{
    protected function getDefaultHandler(): HandlerInterface
    {
        return new AbstractEasyGoingLoggerTestHandlerClazz();
    }

    protected function getDefaultProcessor(): ProcessorInterface
    {
        return new AbstractEasyGoingLoggerTestProcessorClazz();
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new AbstractEasyGoingLoggerTestFormatterClazz();
    }
}

class AbstractEasyGoingLoggerTest extends TestCase
{
    use TraitForAbstractEasyGoingLogger;

    /** @var AbstractEasyGoingLoggerTestClazz $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new AbstractEasyGoingLoggerTestClazz(self::class);
    }

    public function testGetConsoleHandler(): void
    {
        $result = $this->callMethodOnO2t("getConsoleHandler");

        static::assertInstanceOf(ConsoleHandler::class, $result);
        static::assertInstanceOf(AbstractEasyGoingLoggerTestFormatterClazz::class, $result->getFormatter());
    }

    public function testCreateWithDifferentTimezone(): void
    {
        $customDTZ = new DateTimeZone("America/Los_Angeles");
        $o2tb      = new AbstractEasyGoingLoggerTestClazz(self::class, [], [], $customDTZ);

        static::assertInstanceOf(AbstractEasyGoingLoggerTestClazz::class, $o2tb);
        static::assertEquals($customDTZ, $o2tb->getTimezone());
    }
}
