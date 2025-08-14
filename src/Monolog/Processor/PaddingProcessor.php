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
 * Class PaddingProcessor
 *
 * Use Introspection from @link IntrospectionProcessor.
 *
 * @package Monolog\Processor
 * @see     IntrospectionProcessor
 */
class PaddingProcessor implements ProcessorInterface
{
    /** @var int */
    private $level;
    /** @var string[] */
    private $skipClassesPartials;
    /** @var int */
    private $skipStackFramesCount;
    /** @var string[] */
    private $skipFunctions = [

        'call_user_func',
        'call_user_func_array'
    ];

    /**
     *
     * @param mixed    $level
     *            The minimum logging level at which this Processor will be triggered
     * @param string[] $skipClassesPartials
     * @param int      $skipStackFramesCount
     */
    public function __construct(mixed $level = Logger::DEBUG, array $skipClassesPartials = [], int $skipStackFramesCount = 0)
    {
        $this->level                = Logger::toMonologLevel($level);
        $this->skipClassesPartials  = array_merge([

            'Monolog\\'
        ], $skipClassesPartials);
        $this->skipStackFramesCount = $skipStackFramesCount;
    }

    /**
     *
     * @param mixed[] $record
     *
     * @return mixed[]
     */
    public function __invoke(array $record): array
    {
        $record                   = $this->__invokeIntrospection($record);
        $record['level_name_pad'] = str_pad($record['level_name'], 8, ' ', STR_PAD_RIGHT);

        return $record;
    }

    /**
     *
     * @param mixed[] $record
     *
     * @return mixed[]
     */
    private function __invokeIntrospection(array $record): array
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

        $i = 0;

        while ($this->isTraceClassOrSkippedFunction($trace, $i)) {
            if (isset($trace[$i]['class'])) {
                foreach ($this->skipClassesPartials as $part) {
                    if (strpos($trace[$i]['class'], $part) !== false) {
                        $i++;

                        continue 2;
                    }
                }
            } elseif (in_array($trace[$i]['function'], $this->skipFunctions)) {
                $i++;

                continue;
            }

            break;
        }

        $i += $this->skipStackFramesCount;

        // we should have the call source now
        if ($i > 0) {
            $record = array_merge($record, [

                'xFile'     => $trace[$i - 1]['file'] ?? null,
                'xLine'     => $trace[$i - 1]['line'] ?? null,
                'xClass'    => $trace[$i]['class'] ?? null,
                'xCallType' => $trace[$i]['type'] ?? null,
                'xFunction' => $trace[$i]['function'] ?? null
            ]);
        }

        return $record;
    }

    /**
     *
     * @param mixed[] $trace
     * @param int     $index
     *
     * @return bool
     */
    private function isTraceClassOrSkippedFunction(array $trace, int $index): bool
    {
        if (!isset($trace[$index])) {
            return false;
        }

        return isset($trace[$index]['class']) || in_array($trace[$index]['function'], $this->skipFunctions);
    }
}
