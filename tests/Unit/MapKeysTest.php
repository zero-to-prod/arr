<?php

namespace Tests\Unit;

use stdClass;
use Tests\TestCase;
use TypeError;
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

    /** @test */
    public function it_can_transform_simple_string_keys(): void
    {
        $array = ['foo' => 1, 'bar' => 2];
        $result = Arr::mapKeys($array, 'strtoupper');

        $this->assertEquals(['FOO' => 1, 'BAR' => 2], $result);
    }

    /** @test */
    public function it_can_transform_numeric_keys(): void
    {
        $array = [1 => 'one', 2 => 'two'];
        $result = Arr::mapKeys($array, static function ($key) {
            return $key * 2;
        });

        $this->assertEquals([2 => 'one', 4 => 'two'], $result);
    }

    /** @test */
    public function it_handles_nested_arrays(): void
    {
        $array = [
            'first' => [
                'nested' => 'value',
                'other' => ['deep' => 'nested_value']
            ],
            'second' => 'value2'
        ];

        $result = Arr::mapKeys($array, 'strtoupper');

        $expected = [
            'FIRST' => [
                'NESTED' => 'value',
                'OTHER' => ['DEEP' => 'nested_value']
            ],
            'SECOND' => 'value2'
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_handles_empty_arrays(): void
    {
        $array = [];
        $result = Arr::mapKeys($array, 'strtoupper');

        $this->assertEquals([], $result);
    }

    /** @test */
    public function it_preserves_values_of_different_types(): void
    {
        $array = [
            'int' => 42,
            'float' => 3.14,
            'string' => 'hello',
            'bool' => true,
            'null' => null,
            'array' => [1, 2, 3],
            'object' => new stdClass(),
        ];

        $result = Arr::mapKeys($array, static function ($key) {
            return "prefix_$key";
        });

        $this->assertSame(42, $result['prefix_int']);
        $this->assertSame(3.14, $result['prefix_float']);
        $this->assertSame('hello', $result['prefix_string']);
        $this->assertTrue($result['prefix_bool']);
        $this->assertNull($result['prefix_null']);
        $this->assertInstanceOf(stdClass::class, $result['prefix_object']);
    }

    /** @test */
    public function it_works_with_complex_key_transformations(): void
    {
        $array = ['test' => 1, 'another_test' => 2];
        $result = Arr::mapKeys($array, static function ($key) {
            return md5($key);
        });

        $expected = [
            md5('test') => 1,
            md5('another_test') => 2
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_maintains_key_uniqueness(): void
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $result = Arr::mapKeys($array, static function () {
            return 'same_key';
        });

        $this->assertEquals(['same_key' => 3], $result);
    }

    /** @test */
    public function it_handles_arrays_with_integer_keys(): void
    {
        $array = [
            0 => 'zero',
            1 => 'one',
            2 => 'two'
        ];

        $result = Arr::mapKeys($array, static function ($key) {
            return $key + 10;
        });

        $this->assertEquals([
            10 => 'zero',
            11 => 'one',
            12 => 'two'
        ], $result);
    }

    /** @test */
    public function it_handles_deeply_nested_arrays(): void
    {
        $array = [
            'level1' => [
                'level2' => [
                    'level3' => [
                        'deep' => 'value'
                    ]
                ]
            ]
        ];

        $result = Arr::mapKeys($array, 'strtoupper');

        $expected = [
            'LEVEL1' => [
                'LEVEL2' => [
                    'LEVEL3' => [
                        'DEEP' => 'value'
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_preserves_array_structure_with_numeric_and_string_keys_mixed(): void
    {
        $array = [
            'string_key' => 'value1',
            42 => 'value2',
            'another_key' => [
                1 => 'nested1',
                'nested_key' => 'nested2'
            ]
        ];

        $result = Arr::mapKeys($array, static function ($key) {
            return is_string($key) ? strtoupper($key) : $key * 2;
        });

        $expected = [
            'STRING_KEY' => 'value1',
            84 => 'value2',
            'ANOTHER_KEY' => [
                2 => 'nested1',
                'NESTED_KEY' => 'nested2'
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_throws_exception_for_invalid_keys(): void
    {
        $array = ['key' => 'value'];

        $this->expectException(TypeError::class);

        // Attempting to create an array with an invalid key type (array)
        Arr::mapKeys($array, static function () {
            return [];
        });
    }
}