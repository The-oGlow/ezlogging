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

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class CsvLoggerTest extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testLogger()
    {
        $o = new CsvLogger('mycsv', 'C:\temp');

        $o->debug("Hallo");
    }
}
