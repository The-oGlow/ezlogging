<?php

declare(strict_types=1);

namespace Monolog\Formatter;

class EasyGoingFormatter extends LineFormatter
{
    public const FORMATTER_OUTPUT     = "\n%datetime% [%level_name_pad%] %channel%->%xFunction%() - %message% %context% %extra%";
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
