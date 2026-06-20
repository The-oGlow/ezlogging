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

class DoNothingLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTest\AbstractEasyGoingLoggerTestTrait;

    protected TestHandler $testHandler;

    protected DoNothingLogger $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->testHandler = new TestHandler();
        $this->o2t = new DoNothingLogger();
    }

    /**
     * @param string $methodName
     */
    #[DataProvider('providerMethods')]
    public function testNothingHappens(string $methodName): void
    {
        $expectedCount = 0;
        $expectedRegex = '/^$/';

        $message = 'Write a log entry';

        $this->o2t->$methodName($message);

        self::expectOutputRegex($expectedRegex);
        self::assertCount($expectedCount, $this->testHandler->getRecords());
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
