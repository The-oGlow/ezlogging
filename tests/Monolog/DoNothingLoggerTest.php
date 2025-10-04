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

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\EasyGoingTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class DoNothingLoggerTest extends TestCase
{
    use AbstractEasyGoingLoggerTestTrait;

    /** @var DoNothingLogger */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new DoNothingLogger();
    }

    public function testNothingHappens(): void
    {
        $message  = 'Write a log entry';
        $expected = '/^$/m';

        $this->o2t->info($message);

        static::expectOutputRegex($expected);
    }
}
