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

use Monolog\Formatter\EasyGoingFormatter;
use Monolog\Handler\ConsoleHandler;
use Monolog\Processor\PaddingProcessor;
use ollily\Tools\Reflection\UnavailableMethodsTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class PlainLoggerTest extends TestCase
{
    use TraitForAbstractEasyGoingLogger;
    /** @var PlainLogger $o2t */
    private $o2t;
    /** @var string[] $logMethods */
    private $logMethods = ['debug', 'info', 'notice', 'warning', 'alert', 'emergency'];
    /** @var mixed[] $context */
    private $context = ['value 1', 2 => 'value 2', 3];

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new PlainLogger(self::class);
    }

    public function testOut(): void
    {
        $msg = "logging with 'out'";

        try
        {
            $this->o2t->out($msg);
            static::assertTrue(true); // @phpstan-ignore staticMethod.alreadyNarrowedType
        } catch (\Exception $e)
        {
            static::fail($e->getMessage());
        }
    }

    public function testLog(): void
    {
        static::assertTrue(
            $this->log($this->logMethods)
        );
    }

    public function testLogWithContext(): void
    {
        static::assertTrue(
            $this->log($this->logMethods, $this->context)
        );
    }

    public function testLogMethods(): void
    {
        static::assertTrue(
            $this->logMethods($this->logMethods)
        );
    }

    public function testLogMethodsWithContext(): void
    {
        static::assertTrue(
            $this->logMethods($this->logMethods, $this->context)
        );
    }

    /**
     * @param string[] $levels
     * @param mixed[]  $context
     *
     * @return bool
     */
    private function log(array $levels, array $context = []): bool
    {
        $result = false;

        try
        {
            foreach ($levels as $level)
            {
                $msg = "logging with log & '$level'" . (empty($context) ? '' : ' & a context');
                $this->o2t->log($level, $msg, $context);
                $result = true;
            }
        } catch (\Exception $e)
        {
            print_r($e);
        }

        return $result;
    }

    /**
     * @param string[] $logMethods
     * @param mixed[]  $context
     *
     * @return bool
     */
    private function logMethods(array $logMethods, array $context = []): bool
    {
        $result = false;

        try
        {
            foreach ($logMethods as $logMethod)
            {
                $msg = "logging with '$logMethod'" . (empty($context) ? '' : ' & a context');
                $this->o2t->$logMethod($msg, $context); // @phpstan-ignore method.dynamicName
                $result = true;
            }
        } catch (\Exception $e)
        {
            print_r($e);
        }

        return $result;
    }
}
