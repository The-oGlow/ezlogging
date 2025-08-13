<?php

/**
 * Created by PhpStorm.
 * User: GLO03
 * Date: 13.08.2025
 * Time: 17:15
 */

namespace Monolog\Formatter;

use ollily\Tools\Reflection\UnavailableFieldsTrait;
use PHPUnit\Framework\TestCase;

class PlainFormatterTest extends TestCase
{
    use UnavailableFieldsTrait;
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
