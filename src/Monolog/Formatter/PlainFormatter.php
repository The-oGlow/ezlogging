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

class PlainFormatter extends LineFormatter
{
    /** @var string */
    public const FORMATTER_OUTPUT = "\n%message%";
    /** @var string */
    public const FORMATTER_DATEFORMAT = "Ymd-Gis.v";

    /**
     * @param string  $format
     * @param string  $dateFormat
     * @param boolean $allowInlineLineBreaks
     * @param boolean $ignoreEmptyContextAndExtra
     * @param boolean $includeStacktraces
     */
    public function __construct(// @phpstan-ignore constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter, constructor.unusedParameter
        $format = self::FORMATTER_OUTPUT,
        $dateFormat = self::FORMATTER_DATEFORMAT,
        $allowInlineLineBreaks = true,
        $ignoreEmptyContextAndExtra = true,
        $includeStacktraces = false
    ) {
        parent::__construct(self::FORMATTER_OUTPUT, self::FORMATTER_DATEFORMAT, true, true, false);
    }
}
