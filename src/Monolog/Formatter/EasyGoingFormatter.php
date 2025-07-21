<?php

declare(strict_types=1);

namespace Monolog\Formatter;

class EasyGoingFormatter extends LineFormatter
{
    /** @var string */
    public const FORMATTER_OUTPUT     = "\n%datetime% [%level_name_pad%] %channel%->%xFunction%() - %message% %context% %extra%";
    /** @var string */
    public const FORMATTER_DATEFORMAT = "Ymd-Gis.v";

    /**
     * @param string $format
     * @param string $dateFormat
     * @param boolean $allowInlineLineBreaks
     * @param boolean $ignoreEmptyContextAndExtra
     * @param boolean $includeStacktraces
     */
    public function __construct( // @phpstan-ignore constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter
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
