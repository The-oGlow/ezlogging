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

namespace Monolog\Formatter;

use Monolog\Logger;
use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class EasyGoingFormatterTest extends TestCase
{
    use UnavailableFieldsTrait;

    /** @var EasyGoingFormatter */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new EasyGoingFormatter();
    }

    public function testConfiguration(): void
    {
        static::assertInstanceOf(EasyGoingFormatter::class, $this->o2t);
        static::assertEquals($this->o2t::FORMATTER_OUTPUT, $this->getFieldFromO2t('format'));
        static::assertEquals($this->o2t::FORMATTER_DATEFORMAT, $this->o2t->getDateFormat());
        static::assertTrue($this->getFieldFromO2t('allowInlineLineBreaks'));
        static::assertTrue($this->getFieldFromO2t('ignoreEmptyContextAndExtra'));
        static::assertFalse($this->getFieldFromO2t('includeStacktraces'));
    }
}
