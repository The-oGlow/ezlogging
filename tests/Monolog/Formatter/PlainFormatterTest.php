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

    /** @var PlainFormatter $o2t */
    private $o2t;

    public function setUp(): void
    {
        parent::setUp();

        $this->o2t = new PlainFormatter();

    }

    public function testConfiguration(): void
    {
        $this::assertInstanceOf(PlainFormatter::class, $this->o2t);
        $this::assertEquals($this->o2t::FORMATTER_OUTPUT, $this->getFieldFromO2t('format'));
        $this::assertEquals($this->o2t::FORMATTER_DATEFORMAT, $this->o2t->getDateFormat());
        $this::assertEquals(true, $this->getFieldFromO2t('allowInlineLineBreaks'));
        $this::assertEquals(true, $this->getFieldFromO2t('ignoreEmptyContextAndExtra'));
        $this::assertEquals(false, $this->getFieldFromO2t('includeStacktraces'));

    }

}
