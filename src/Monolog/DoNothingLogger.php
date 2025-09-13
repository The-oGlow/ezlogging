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

namespace Monolog;

use Psr\Log\LoggerInterface;

/**
 * This logger does exactly: <strong>nothing</strong>!
 */
class DoNothingLogger implements LoggerInterface, ResettableInterface
{
    /**
     * System is unusable.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function emergency($message, array $context = [])
    {
        // no content for  emergency() method.
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function alert($message, array $context = [])
    {
        // no content for  alert() method.
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function critical($message, array $context = [])
    {
        // no content for  critical() method.
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function error($message, array $context = [])
    {
        // no content for  error() method.
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function warning($message, array $context = [])
    {
        // no content for  warning() method.
    }

    /**
     * Normal but significant events.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function notice($message, array $context = [])
    {
        // no content for  notice() method.
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function info($message, array $context = [])
    {
        // no content for  info() method.
    }

    /**
     * Detailed debug information.
     *
     * @param string  $message
     * @param mixed[] $context
     */
    public function debug($message, array $context = [])
    {
        // no content for  debug() method.
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed   $level
     * @param string  $message
     * @param mixed[] $context
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        // no content for  log() method.
    }

    public function reset()
    {
        // no content for  reset() method.
    }

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $data
     */
    public function __unserialize(array $data): void
    {
        // no content for  __unserialize() method.
    }
}
