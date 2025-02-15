<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Zerotoprod\Arr\Arr;

class SetTest extends TestCase
{
    /** @test */
    public function it_can_set_a_value_with_dot_notation(): void
    {
        $array = [
            'Key1' => [
                'Key2' => 1
            ]
        ];

        $new_array = Arr::set($array, 'Key1.Key2', 2);

        $this->assertEquals([
            'Key1' => [
                'Key2' => 2
            ]
        ], $new_array);
    }

    /** @test */
    public function it_creates_intermediate_keys_if_they_do_not_exist(): void
    {
        $array = [];

        $new_array = Arr::set($array, 'Key1.Key2.Key3', 'value');

        $this->assertEquals([
            'Key1' => [
                'Key2' => [
                    'Key3' => 'value'
                ]
            ]
        ], $new_array);
    }

    /** @test */
    public function it_can_set_a_value_in_a_nested_array(): void
    {
        $array = [
            'user' => [
                'info' => [
                    'name' => 'John'
                ]
            ]
        ];

        $new_array = Arr::set($array, 'user.info.name', 'Jane');

        $this->assertEquals([
            'user' => [
                'info' => [
                    'name' => 'Jane'
                ]
            ]
        ], $new_array);
    }

    /** @test */
    public function it_can_set_a_value_with_no_dot_notation(): void
    {
        $array = [];
        $new_array = Arr::set($array, 'key', 'value');

        $this->assertEquals(['key' => 'value'], $new_array);
    }

    /** @test */
    public function it_merges_arrays_when_key_is_not_a_string(): void
    {
        $array = ['a' => 1];
        $new_array = Arr::set($array, ['b' => 2]);

        $this->assertEquals(['a' => 1, 'b' => 2], $new_array);
    }

    /** @test */
    public function it_uses_a_callback_to_modify_the_array(): void
    {
        $array = ['a' => 1];
        $new_array = Arr::set($array, function ($array) {
            $array['b'] = 2;

            return $array;
        });

        $this->assertEquals(['a' => 1, 'b' => 2], $new_array);
    }

    /** @test */
    public function it_handles_an_empty_string_for_key(): void
    {
        $array = ['a' => 1];
        $new_array = Arr::set($array, '', 'value');

        $this->assertEquals(['a' => 1], $new_array);
    }

    /** @test */
    public function it_handles_an_empty_array_as_key(): void
    {
        $array = ['a' => 1];
        $new_array = Arr::set($array, []);

        $this->assertEquals(['a' => 1], $new_array);
    }

    /** @test */
    public function it_does_not_modify_the_original_array(): void
    {
        $original = ['a' => 1];
        Arr::set($original, 'b', 2);

        $this->assertEquals(['a' => 1], $original);
    }
}