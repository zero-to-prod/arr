<?php

namespace Zerotoprod\Arr;

class Arr
{
    public static function mapKeys(array $array, callable $function): array
    {
        $new_array = [];

        foreach ($array as $key => $value) {
            $new_key = $function($key);

            if (is_array($value)) {
                $value = self::mapKeys($value, $function);
            }

            $new_array[$new_key] = $value;
        }

        return $new_array;
    }
}