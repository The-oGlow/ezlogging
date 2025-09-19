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

namespace ollily\Tools\String;

trait ImplodeTrait
{
    /**
     * Recursively implodes an array with optional key inclusion.
     *
     * Example of $include_keys output: key, value, key, value, key, value
     *
     * @param string $separator   value that glues elements together
     * @param mixed  $anyData     multi-dimensional array to recursively implode
     * @param bool   $textSep     add a text seperator (") around each value of a scalar type (default: false)
     * @param bool   $displayKeys include keys before their values (default: false)
     *
     * @return string imploded array
     *
     * @see https://www.php.net/manual/en/language.types.type-system.php
     */
    protected function arrayRecImplode(string $separator, $anyData, bool $textSep = false, bool $displayKeys = false): string
    {
        $sepChar = $textSep ? '"' : '';
        $output   = '';
        $valueIdx = 0;
        if (is_array($anyData) || is_object($anyData)) {
            foreach ($anyData as $key => $value) {
                $output .= ($valueIdx ? $separator : '') . ($displayKeys ? (is_int($key) ? $key : "'" . $key . "'") . '=>' : '');
                if (is_array($value)) {
                    $arrOutput = $this->arrayRecImplode($separator, $value, $textSep, $displayKeys);
                    if ($arrOutput) {
                        $output .= '[' . $arrOutput . ']';
                    } else {
                        $output .= '[]';
                    }
                } else {
                    if (is_object($value)) {
                        $objOutput = $this->arrayRecImplode($separator, $value, $textSep, $displayKeys);
                        if ($objOutput) {
                            $output .= '{' . $objOutput . '}';
                        } else {
                            $output .= '{}';
                        }
                    } else {
                        $output .= $sepChar . $value . $sepChar;
                    }
                }
                $valueIdx++;
            }
        } else {
            $output = $anyData;
        }

        return $output;
    }
}
