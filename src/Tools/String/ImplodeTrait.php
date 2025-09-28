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

use ArrayAccess;
use Stringable;

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
     * @param bool   $displayKeys include keysForValue before their values (default: false)
     *
     * @return string imploded array
     *
     * @see https://www.php.net/manual/en/language.types.type-system.php
     */
    protected function implodeRecursive(string $separator, $anyData, bool $textSep = false, bool $displayKeys = false): string
    {
        $sepChar  = $textSep ? '"' : '';
        $output   = '';
        $valueIdx = 0;
        if (is_array($anyData) || (is_object($anyData) && is_subclass_of($anyData, ArrayAccess::class))) {
            /**
             * @psalm-suppress PossibleRawObjectIteration,PossiblyInvalidIterator
             * @phpstan-ignore foreach.nonIterable
             */
            foreach ($anyData as $key => $value) {
                // @phpstan-ignore ternary.condNotBoolean
                $output .= ($valueIdx ? $separator : '') . ($displayKeys ? (is_int($key) ? $key : "'" . $key . "'") . '=>' : '');
                if (is_array($value)) {
                    $arrOutput = $this->implodeRecursive($separator, $value, $textSep, $displayKeys);
                    if (!empty($arrOutput)) {
                        $output .= '[' . $arrOutput . ']';
                    } else {
                        $output .= '[]';
                    }
                } else {
                    if (is_object($value)) {
                        $objOutput = $this->implodeRecursive($separator, $value, $textSep, $displayKeys);
                        if (!empty($objOutput)) {
                            $output .= '{' . $objOutput . '}';
                        } else {
                            $output .= '{}';
                        }
                    } else {
                        $output .= $sepChar . ((string) $value) . $sepChar;
                    }
                }
                $valueIdx++;
            }
        } else {
            if (is_object($anyData)) {
                if ($anyData instanceof Stringable) {
                    $output = $anyData->__toString();
                } else {
                    $output = get_class($anyData);
                }
            } else {
                $output = $anyData;
            }
        }

        return $output;
    }

    /**
     *          Flatten a multidimensional array to one dimension, optionally preserving keys.
     * Original found on {@link https://stackoverflow.com/a/526633}.
     *
     * @param array          <mixed,mixed> $array         the array to flatten
     * @param int                          $preserve_keys 0 (default) to not preserve keys, 1 to preserve string keys only, 2 to preserve all keys
     * @param array          <mixed,mixed> $out           internal use argument for recursion
     *
     * @return array<mixed,mixed>
     *
     * @see https://stackoverflow.com/a/526633
     */
    public function array_flatten(array $array, int $preserve_keys = 0, array &$out = []): array // @phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        foreach ($array as $key => $child) {
            if (is_array($child)) {
                $out = $this->array_flatten($child, $preserve_keys, $out);
            } elseif ($preserve_keys + (int)is_string($key) > 1) {
                $out[$key] = $child;
            } else {
                $out[] = $child;
            }
        }

        return $out;
    }
}
