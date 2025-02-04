<?php

namespace Tests\Unit;

use Tests\TestCase;
use Zerotoprod\Arr\Arr;

class MapKeysTest extends TestCase
{
    /** @test */
    public function map_keys(): void
    {
        $array = [
            'Key1' => [
                'Key2' => 1
            ]
        ];

        $new_array = Arr::mapKeys($array, static function (string $key) {
            return strtolower($key);
        });

        self::assertEquals(1, $new_array['key1']['key2']);
    }
}