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
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PaddingProcessor;
use PHPUnit\Framework\TestCase;
use ollily\Tools\Reflection\UnavailableMethodsTrait;

require_once __DIR__.  '/../bootstrap.php';

class ConsoleLoggerTest extends TestCase
{
    use TraitForAbstractEasyGoingLogger;

    /** @var ConsoleLogger $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();
        $this->o2t = new ConsoleLogger(self::class);
    }
}
