<?php

declare(strict_types=1);

namespace Monolog\Processor;

use Monolog;

class PlainProcessor implements ProcessorInterface 
{
    /**
     * @param mixed[]           $record
     *
     * @return mixed[] The processed record
     */
    public function __invoke(array $record)
    {
        return $record;
    }
}
