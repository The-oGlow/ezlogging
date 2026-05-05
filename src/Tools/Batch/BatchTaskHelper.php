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

namespace ollily\Tools\Batch;

use Ds\Map;
use Monolog\ConsoleLogger;
use Psr\Log\LoggerInterface;

class BatchTaskHelper
{
    public const DEFAULT = 'DEFAULT';

    /** @var \Ds\Map<mixed,TaskList> */
    private static $tasklists;

    /** @var LoggerInterface */
    private static $logger;

    public function __construct()
    {
        self::$logger = new ConsoleLogger(BatchTaskHelper::class);
        self::$logger->debug('START');

        self::$tasklists = new Map();

        self::$logger->debug('END');
    }

    /**
     * @param string $listKey
     *
     * @return TaskList
     */
    public static function getTaskList(string $listKey = self::DEFAULT): TaskList
    {
        if (!self::$tasklists->hasKey($listKey)) {
            self::$tasklists->put($listKey, new TaskList($listKey));
        }

        return self::$tasklists->get($listKey);
    }

    /**
     * @param string $fileName
     * @param string $listKey
     *
     * @return TaskList
     */
    public function readTaskList(string $fileName, string $listKey = self::DEFAULT)
    {
        if (file_exists($fileName)) {
            $taskList = self::getTaskList($listKey);
            $taskList->readFile($fileName);
        } else {
            self::$logger->warning('File does not exists!', [$fileName]);
            $taskList = self::getTaskList($listKey);
        }

        return $taskList;
    }
}
