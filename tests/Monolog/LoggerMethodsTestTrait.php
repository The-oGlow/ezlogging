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

/**
 * @author postm
 */
trait LoggerMethodsTestTrait
{
    protected TestHandler $testHandler;

    /** @var array<mixed,mixed> */
    private array $context = ['value 1', 2 => 'value 2', 3];

    protected function initLoggerMethodsTestTrait(mixed &$o2t): void
    {
        $this->testHandler = new TestHandler();
        $o2t->pushHandler($this->testHandler);
    }

    public function testOut(): void
    {
        $msg = "logging with 'out'";
        $checkMethod = sprintf("has%sThatContains", 'Info');

        try {
            $this->o2t->out($msg);
        } catch (\Exception $except) {
            echo $except->getMessage();
        }
        self::assertTrue($this->testHandler->$checkMethod($msg), sprintf("Not found a message like '%s'", $msg));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLog(string $methodName): void
    {
        $expectedRegex = "/log with '{$methodName}'/";
        $checkMethod = sprintf("has%sThatMatches", $methodName);

        $actual = $this->log($methodName);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->$checkMethod($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogWithContext(string $methodName): void
    {
        $expectedRegex = "/log() with '{$methodName}' & (value \d,){2}\d/";
        $checkMethod = sprintf("has%sThatMatches", $methodName);

        $actual = $this->log($methodName, $this->context);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->$checkMethod($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogMethods(string $methodName): void
    {
        $expectedRegex = "/log-method with '{$methodName}'/";
        $checkMethod = sprintf("has%sThatMatches", $methodName);

        $actual = $this->logMethods($methodName);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->$checkMethod($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testLogMethodsWithContext(string $methodName): void
    {
        $expectedRegex = "/log-method with '{$methodName}' & (value \d,){2}\d/";
        $checkMethod = sprintf("has%sThatMatches", $methodName);

        $actual = $this->logMethods($methodName, $this->context);

        self::assertTrue($actual);
        self::assertTrue($this->testHandler->$checkMethod($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
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
            $msg = "log with '$level'" . (empty($context) ? '' : ' & ' . implode(',', $context));
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
            $msg = "log-method with '$logMethod'" . (empty($context) ? '' : ' & ' . implode(',', $context));
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
            'debug' => ['Debug'],
            'info' => ['Info'],
            'notice' => ['Notice'],
            'warning' => ['Warning'],
            'alert' => ['Alert'],
            'emergency' => ['Emergency'],
        ];
    }
}
