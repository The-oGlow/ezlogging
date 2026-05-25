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

use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class PlainFormatterTest extends TestCase
{
    use UnavailableFieldsTrait;

    protected PlainFormatter $o2t;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PlainFormatter();
    }

    public function testConfiguration(): void
    {
        self::assertInstanceOf(PlainFormatter::class, $this->o2t);
        self::assertEquals($this->o2t::FORMATTER_OUTPUT, $this->getFieldFromO2t('format'));
        self::assertEquals($this->o2t::FORMATTER_DATEFORMAT, $this->o2t->getDateFormat());
        self::assertTrue($this->getFieldFromO2t('allowInlineLineBreaks'));
        self::assertTrue($this->getFieldFromO2t('ignoreEmptyContextAndExtra'));
        self::assertFalse($this->getFieldFromO2t('includeStacktraces'));
    }
}
