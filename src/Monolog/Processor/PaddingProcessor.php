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

use Monolog\Logger;

/**
 * Class PaddingProcessor.
 *
 * Use Introspection from @see IntrospectionProcessor.
 *
 * @see     IntrospectionProcessor
 *
 * @phpstan-import-type Level from \Monolog\Logger
 * @phpstan-import-type LevelName from \Monolog\Logger
 *
 * @phpstan-type Record array<mixed,mixed>
 */
class PaddingProcessor implements ProcessorInterface
{
    private int $level;

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
     * @param array $record A record
     *
     * @phpstan-param Record $record A record
     *
     * @return array The processed record
     *
     * @phpstan-return Record
     *
     * @phpstan-ignore method.childReturnType
     */
    #[\Override]
    public function __invoke(array $record): array
    {
        $record                   = $this->__invokeIntrospection($record);
        $record['level_name_pad'] = str_pad($record['level_name'], 8, ' ', STR_PAD_RIGHT);

        return $record;
    }

    /**
     * @param array<mixed,mixed> $record
     *
     * @return array<mixed,mixed>
     */
    private function __invokeIntrospection(array $record): array // NOSONAR: php:S100
    {
        // return if the level is not high enough
        if ($record['level'] < $this->level) {
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
            $record    = array_merge($record, $xDetails);
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
