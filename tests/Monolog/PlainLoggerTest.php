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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlainLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;
    use LoggerMethodsTestTrait;

    protected PlainLogger $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new PlainLogger(self::class);
        $this->initLoggerMethodsTestTrait($this->o2t);
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testOut(string $methodName): void
    {
        $message = 'Write a log entry';
        $expectedRegex = sprintf('/^%s$/', $message);
        $checkMethod = sprintf("has%sThatMatches", $methodName);

        $this->o2t->out($message, $methodName);

        self::assertTrue($this->testHandler->$checkMethod($expectedRegex), sprintf("Not found a message like '%s'", $expectedRegex));
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
