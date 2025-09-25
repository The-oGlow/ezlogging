<?php
/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 25.09.2025
 * Time: 14:43
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
