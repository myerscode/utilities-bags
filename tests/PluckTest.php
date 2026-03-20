<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class PluckTest extends BaseBagSuite
{
    public function test_pluck_extracts_values(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
        ]);
        $this->assertSame(['Fred', 'Tor'], $bag->pluck('name')->toArray());
    }

    public function test_pluck_on_empty_bag(): void
    {
        $this->assertSame([], $this->utility([])->pluck('name')->toArray());
    }

    public function test_pluck_returns_null_for_missing_keys(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred'],
            ['age' => 25],
        ]);
        $this->assertSame(['Fred', null], $bag->pluck('name')->toArray());
    }

    public function test_pluck_with_boolean_values(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'active' => true],
            ['name' => 'Tor', 'active' => false],
        ]);
        $this->assertSame([true, false], $bag->pluck('active')->toArray());
    }

    public function test_pluck_with_duplicate_key_path_values(): void
    {
        $bag = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 1, 'name' => 'Tor'],
        ]);
        $result = $bag->pluck('name', 'id');
        $this->assertSame([1 => 'Tor'], $result->toArray());
    }

    public function test_pluck_with_key_path(): void
    {
        $bag = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 2, 'name' => 'Tor'],
        ]);
        $this->assertSame([1 => 'Fred', 2 => 'Tor'], $bag->pluck('name', 'id')->toArray());
    }

    public function test_pluck_with_mixed_item_types(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred'],
            'not an array',
            ['name' => 'Tor'],
        ]);
        $this->assertSame(['Fred', null, 'Tor'], $bag->pluck('name')->toArray());
    }

    public function test_pluck_with_null_values_in_column(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'email' => null],
            ['name' => 'Tor', 'email' => 'tor@example.com'],
        ]);
        $this->assertSame([null, 'tor@example.com'], $bag->pluck('email')->toArray());
    }

    public function test_pluck_with_numeric_string_keys(): void
    {
        $bag = $this->utility([
            ['0' => 'zero', '1' => 'one'],
            ['0' => 'two', '1' => 'three'],
        ]);
        $this->assertSame(['zero', 'two'], $bag->pluck('0')->toArray());
    }
}
