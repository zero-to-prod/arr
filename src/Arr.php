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
     * @param  array<TKey, TValue>  $array
     * @param  callable(TKey): TNewKey  $callback
     * @return array<TNewKey, TValue>
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
}