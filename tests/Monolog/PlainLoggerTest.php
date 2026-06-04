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

use Monolog\Handler\TestHandler;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlainLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;

    protected PlainLogger $o2t;

    protected TestHandler $testHandler;

    /** @var array<mixed,mixed> */
    private array $context = ['value 1', 2 => 'value 2', 3];

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new PlainLogger(self::class);
        $this->testHandler = new TestHandler();
        $this->o2t->pushHandler($this->testHandler);
    }

    public function testOut(): void
    {
        $msg = "logging with 'out'";

        try {
            $this->o2t->out($msg);
        } catch (\Exception $except) {
            echo $except->getMessage();
        }
        self::assertTrue($this->testHandler->hasInfoThatContains($msg));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLog(string $methodName): void
    {
        $expectedRegex = "/logging with log & '{$methodName}'/";

        $actual = $this->log($methodName);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->hasInfoThatMatches($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogWithContext(string $methodName): void
    {
        $expectedRegex = "/logging with log & '{$methodName}' & (value \d,){2}\d/";

        $actual = $this->log($methodName, $this->context);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->hasInfoThatMatches($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogMethods(string $methodName): void
    {
        $expectedRegex = "/logging with '{$methodName}'/";

        $actual = $this->logMethods($methodName);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->hasInfoThatMatches($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogMethodsWithContext(string $methodName): void
    {
        $expectedRegex = "/logging with '{$methodName}' & (value \d,){2}\d/";

        $actual = $this->logMethods($methodName, $this->context);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->hasInfoThatMatches($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string             $level
     * @param array<mixed,mixed> $context
     *
     * @return bool
     */
    private function log(string $level, array $context = []): bool
    {
        $result = false;

        try {
            $msg = "logging with log & '$level'" . (empty($context) ? '' : ' & ' . implode(',', $context));
            /**
             * @psalm-suppress ArgumentTypeCoercion
             * @phpstan-ignore argument.type
             */
            $this->o2t->log($level, $msg, $context);
            $result = true;
        } catch (\Exception $except) {
            print_r($except);
        }

        return $result;
    }

    /**
     * @param string             $logMethod
     * @param array<mixed,mixed> $context
     *
     * @return bool
     */
    private function logMethods(string $logMethod, array $context = []): bool
    {
        $result = false;

        try {
            $msg = "logging with '$logMethod'" . (empty($context) ? '' : ' & ' . implode(',', $context));
            $this->o2t->$logMethod($msg, $context);
            $result = true;
        } catch (\Exception $except) {
            print_r($except);
        }

        return $result;
    }

    /**
     * @return array<mixed,mixed>
     */
    public static function providerMethods(): array
    {
        return [
            'debug' => ['debug'],
            'info' => ['info'],
            'notice' => ['notice'],
            'warning' => ['warning'],
            'alert' => ['alert'],
            'emergency' => ['emergency'],
        ];
    }
}
