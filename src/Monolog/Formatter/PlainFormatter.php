<?php

declare(strict_types=1);

namespace Monolog\Formatter;

class PlainFormatter extends LineFormatter
{
    public const FORMATTER_OUTPUT     = "\n%message%";
    public const FORMATTER_DATEFORMAT = "Ymd-Gis.v";

    public function __construct(
        $format = self::FORMATTER_OUTPUT,
        $dateFormat = self::FORMATTER_DATEFORMAT,
        $allowInlineLineBreaks = true,
        $ignoreEmptyContextAndExtra = true,
        $includeStacktraces = false
    )
    {
        parent::__construct(self::FORMATTER_OUTPUT, self::FORMATTER_DATEFORMAT, true, true, false);
    }
}
