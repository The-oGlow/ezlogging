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

namespace Monolog\Handler;

use PHPUnit\Framework\TestCase;

class ConsoleHandlerTest extends TestCase
{
    /** @var ConsoleHandler */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new ConsoleHandler();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(ConsoleHandler::class, $this->o2t);
    }
}
