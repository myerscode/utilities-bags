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

    public function test_unique_with_strings(): void
    {
        $bag = $this->utility(['apple', 'banana', 'apple', 'cherry', 'banana']);
        $this->assertSame(['apple', 'banana', 'cherry'], array_values($bag->unique()->toArray()));
    }
}
