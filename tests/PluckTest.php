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

    public function test_pluck_with_key_path(): void
    {
        $bag = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 2, 'name' => 'Tor'],
        ]);
        $this->assertSame([1 => 'Fred', 2 => 'Tor'], $bag->pluck('name', 'id')->toArray());
    }
}
