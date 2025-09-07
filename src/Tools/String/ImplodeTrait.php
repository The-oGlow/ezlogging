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

namespace oglowa\tools\Yacorapi\Helper;

trait ImplodeTrait
{
    /**
     * Recursively implodes an array with optional key inclusion.
     *
     * Example of $include_keys output: key, value, key, value, key, value
     *
     * @param string $separator   value that glues elements together
     * @param mixed  $anyData     multi-dimensional array to recursively implode
     * @param bool   $displayKeys include keys before their values
     *
     * @return string imploded array
     */
    protected function arrayRecImplode(string $separator, $anyData, bool $displayKeys = false): string
    {
        $output      = '';
        $value_index = 0;
        if (is_array($anyData) || is_object($anyData)) {
            foreach ($anyData as $key => $value) {
                $output .= ($value_index ? $separator : '') . ($displayKeys ? (is_int($key) ? $key : "'" . $key . "'") . '=>' : '');
                if (is_array($value)) {
                    $array_ouput = $this->arrayRecImplode($separator, $value, $displayKeys);
                    if ($array_ouput) {
                        $output .= '[' . $array_ouput . ']';
                    } else {
                        $output .= '[]';
                    }
                } else {
                    if (is_object($value)) {
                        $object_output = $this->arrayRecImplode($separator, $value, $displayKeys);
                        if ($object_output) {
                            $output .= '{' . $object_output . '}';
                        } else {
                            $output .= '{}';
                        }
                    } else {
                        $output .= '"' . $value . '"';
                    }
                }
                $value_index++;
            }
        } else {
            $output = $anyData;
        }

        return $output;
    }
}
