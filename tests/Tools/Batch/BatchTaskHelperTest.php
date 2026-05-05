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

use PHPUnit\Framework\EasyGoingTestCase;

class BatchTaskHelperTest extends EasyGoingTestCase
{
    /**
     * @return BatchTaskHelper
     */
    protected static function prepareO2t()
    {
        return new BatchTaskHelper();
    }

    /**
     * @return BatchTaskHelper
     */
    protected function getCasto2t()
    {
        return $this->o2t;
    }
}
