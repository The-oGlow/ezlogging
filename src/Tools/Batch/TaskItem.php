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

/**
 * @phpstan-import-type TaskKey from ITaskItem
 * @phpstan-import-type TaskData from ITaskItem
 */
class TaskItem implements ITaskItem
{
    /** @var mixed
     * @phpstan-var TaskKey */
    private $key;

    /**
     * @var array
     *
     * @phpstan-var TaskData
     */
    private $data;

    /**
     * Task constructor.
     *
     * @param mixed $key
     * @param array $data
     *
     * @phpstan-param TaskKey  $key
     * @phpstan-param TaskData $data
     */
    public function __construct($key, array $data)
    {
        $this->key  = $key;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        $value = $this->data;

        foreach (array_keys($value) as $arrayKey) {
            if (is_object($value[$arrayKey]) && $this == $value[$arrayKey]) {
                $value[$arrayKey] = get_class($value[$arrayKey]);
            }
        }

        return sprintf('%s', implode(';', $value));
    }
}
