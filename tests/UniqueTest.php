<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class UniqueTest extends BaseBagSuite
{
    public function test_unique_on_empty_bag(): void
    {
        $this->assertSame([], $this->utility([])->unique()->toArray());
    }

    public function test_unique_preserves_first_key(): void
    {
        $bag = $this->utility([1, 2, 2, 3]);
        $this->assertSame([0 => 1, 1 => 2, 3 => 3], $bag->unique()->toArray());
    }
    public function test_unique_removes_duplicates(): void
    {
        $bag = $this->utility([1, 2, 2, 3, 3, 3]);
        $this->assertSame([1, 2, 3], array_values($bag->unique()->toArray()));
    }

    public function test_unique_single_element(): void
    {
        $this->assertSame([42], $this->utility([42])->unique()->toArray());
    }

    public function test_unique_with_boolean_values(): void
    {
        $bag = $this->utility([true, false, true, false, true]);
        $this->assertCount(2, $bag->unique());
    }

    public function test_unique_with_callback(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor', 'role' => 'dev'],
            ['name' => 'Chris', 'role' => 'design'],
        ]);
        $unique = $bag->unique(fn (array $item): string => $item['role']);
        $this->assertCount(2, $unique);
    }

    public function test_unique_with_mixed_types(): void
    {
        $bag = $this->utility([1, '1', 2, '2', 3]);
        $unique = $bag->unique();
        $this->assertCount(3, $unique);
    }

    public function test_unique_with_nested_arrays(): void
    {
        $bag = $this->utility([['a' => 1], ['a' => 1], ['a' => 2]]);
        $this->assertCount(2, $bag->unique());
    }

    public function test_unique_with_null_values(): void
    {
        $bag = $this->utility([null, 1, null, 2]);
        $this->assertSame([null, 1, 2], array_values($bag->unique()->toArray()));
    }

    public function test_unique_with_strings(): void
    {
        $bag = $this->utility(['apple', 'banana', 'apple', 'cherry', 'banana']);
        $this->assertSame(['apple', 'banana', 'cherry'], array_values($bag->unique()->toArray()));
    }
}
