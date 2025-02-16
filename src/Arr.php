<?php

namespace Zerotoprod\Arr;

class Arr
{
    /**
     * Run a map operation over the keys of the array while preserving values.
     *
     * The callback should return the new key to be used in the resulting array.
     *
     * @template TKey
     * @template TValue
     * @template TNewKey of array-key
     *
     * @param  array<TKey, TValue>      $array
     * @param  callable(TKey): TNewKey  $callback
     *
     * @return array<TNewKey, TValue>
     * @link https://github.com/zero-to-prod/arr
     */
    public static function mapKeys(array $array, callable $callback): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[$callback($key)] = is_array($value)
                ? self::mapKeys($value, $callback)
                : $value;
        }

        return $result;
    }

    /**
     * Set a value on an array with dot syntax or merge with another array/callback.
     *
     * This method allows setting values in nested arrays by using dot notation for keys,
     * merging arrays, or applying a callback function to modify the array.
     *
     * ```
     * Arr::set(['a' => 1], 'b.c', 2) returns ['a' => 1, 'b' => ['c' => 2]]
     * Arr::set(['a' => 1], ['b' => 2]) returns ['a' => 1, 'b' => 2]
     * Arr::set(['a' => 1], function($array) { $array['b'] = 2; return $array; }) returns ['a' => 1, 'b' => 2]
     *```
     *
     * @template TKey of array-key
     * @template TValue
     * @template TNewKey of array-key
     *
     * @param  array<TKey, TValue>    $array  The array to modify
     * @param  callable|array|string  $key    If `$key` is string, dot notation for nested keys; if `$key` is array, merges with `$array`; if callable, modifies `$array`
     * @param  TValue|null            $value  The value to set when `$key`` is a string (optional)
     *
     * @return array<TKey|TNewKey, TValue> The modified array
     */
    public static function set(array $array, $key, $value = null): array
    {
        if ($key === '') {
            return $array;
        }

        if (is_string($key)) {
            $ref = &$array;

            foreach (explode('.', $key) as $sub_key) {
                if (!isset($ref[$sub_key]) || !is_array($ref[$sub_key])) {
                    $ref[$sub_key] = [];
                }
                $ref = &$ref[$sub_key];
            }

            $ref = $value;

            return $array;
        }

        return array_merge(
            $array,
            is_callable($key) ? $key($array) : $key
        );
    }
}