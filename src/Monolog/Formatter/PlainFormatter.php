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
     * PlainFormatter constructor.
     *
     * @param string $format
     * @param string $dateFormat
     * @param bool   $allowInlineLineBreaks
     * @param bool   $ignoreEmptyContextAndExtra
     * @param bool   $includeStacktraces
     *
     * @SuppressWarnings("PHPMD.BooleanArgumentFlag")
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     * @SuppressWarnings("PHPMD.LongVariable")
     */
    public function __construct(
        $format = self::FORMATTER_OUTPUT,
        $dateFormat = self::FORMATTER_DATEFORMAT,
        $allowInlineLineBreaks = true,
        $ignoreEmptyContextAndExtra = true,
        $includeStacktraces = false
    ) {
        parent::__construct(
            self::FORMATTER_OUTPUT,
            self::FORMATTER_DATEFORMAT,
            true,
            true,
            false
        );
    }
}
