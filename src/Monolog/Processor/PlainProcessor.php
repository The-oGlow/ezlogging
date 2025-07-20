<?php

declare(strict_types=1);

namespace Monolog\Processor;

class PlainProcessor implements ProcessorInterface
{
    /**
     * @param array           $record
     *
     * @return array The processed record
     *
     * @phpstan-param  Record $record
     * @phpstan-return Record
     */
    public function __invoke(array $record)
    {
        return $record;
    }
}
