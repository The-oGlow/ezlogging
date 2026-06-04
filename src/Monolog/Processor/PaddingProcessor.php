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

namespace Monolog\Processor;

use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;

/**
 * Class PaddingProcessor.
 *
 * Use Introspection from @see IntrospectionProcessor.
 *
 * @see     IntrospectionProcessor
 *
 */
class PaddingProcessor implements ProcessorInterface
{
    public const string OFFSET_EXTRA = 'extra';

    public const string OFFSET_LEVEL_NAME_PAD = 'level_name_pad';

    public const string OFFSET_LEVEL_NAME = 'level_name';

    public const string OFFSET_LEVEL = 'level';

    public const int LEVEL_WIDTH = 8;

    public const string LEVEL_CHAR = ' ';

    private Level $level;

    /** @var array<string> */
    private array $skipClassesPartials;

    private int $skipStackFramesCount;

    /** @var array<string> */
    private array $skipFunctions = [
        'call_user_func',
        'call_user_func_array',
    ];

    /**
     * @param mixed         $level                The minimum logging level at which this Processor will be triggered
     * @param array<string> $skipClassesPartials
     * @param int           $skipStackFramesCount
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function __construct(mixed $level = Logger::DEBUG, array $skipClassesPartials = [], int $skipStackFramesCount = 0)
    {
        $this->level                = Logger::toMonologLevel($level);
        $this->skipClassesPartials  = array_merge(
            [
                'Monolog\\',
            ],
            $skipClassesPartials
        );
        $this->skipStackFramesCount = $skipStackFramesCount;
    }

    /**
     * @param LogRecord $record A record
     *
     * @return LogRecord The processed record
     */
    #[\Override]
    public function __invoke(LogRecord $record): LogRecord
    {
        /** @var array<mixed,mixed> */
        $extra = $record->offsetGet(self::OFFSET_EXTRA);

        /** @var string $levelName */
        $levelName = $record->offsetGet(self::OFFSET_LEVEL_NAME);
        $extra[self::OFFSET_LEVEL_NAME_PAD] = str_pad($levelName, self::LEVEL_WIDTH, self::LEVEL_CHAR, STR_PAD_RIGHT);

        $record->offsetSet(self::OFFSET_EXTRA, $extra);

        return $record;
    }

    public function __invokeIntrospection(LogRecord $record): LogRecord
    {
        // return if the level is not high enough
        if ($record->level->isLowerThan($this->level)) {
            return $record;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        // skip first since it's always the current method
        array_shift($trace);
        // the call_user_func call is also skipped
        array_shift($trace);

        $index = 0;

        while ($this->isTraceClassOrSkippedFunction($trace, $index)) {
            if (isset($trace[$index]['class'])) {
                foreach ($this->skipClassesPartials as $part) {
                    if (str_contains($trace[$index]['class'], $part)) {
                        $index++;

                        continue 2;
                    }
                }
            } elseif (in_array($trace[$index]['function'], $this->skipFunctions, true)) {
                $index++;

                continue;
            } else {
                break;
            }
            break;
        }

        $index += $this->skipStackFramesCount;

        // we should have the call source now
        if ($index > 0 && $index < count($trace)) {
            $curTrace  = $trace[$index];
            $prevTrace = $trace[$index - 1];
            $xDetails  = [
                'xFile'     => $prevTrace['file'] ?? null,
                'xLine'     => $prevTrace['line'] ?? null,
                'xClass'    => $curTrace['class'] ?? null,
                'xCallType' => $curTrace['type'] ?? null,
                'xFunction' => $curTrace['function'],
            ];
            $record->offsetSet('details', $xDetails);
        }

        return $record;
    }

    /**
     * @param array<mixed,mixed> $trace
     * @param int                $index
     *
     * @return bool
     */
    private function isTraceClassOrSkippedFunction(array $trace, int $index): bool
    {
        if (!isset($trace[$index])) {
            return false;
        }

        return isset($trace[$index]['class']) || in_array($trace[$index]['function'], $this->skipFunctions, true);
    }
}
