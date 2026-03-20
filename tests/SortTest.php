<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SortTest extends BaseBagSuite
{
    public function test_sort_by_callback(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $sorted = $bag->sortBy(fn (array $item): int => $item['age']);
        $this->assertSame('Tor', array_values($sorted->toArray())[0]['name']);
    }

    public function test_sort_by_descending(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $sorted = $bag->sortBy('age', descending: true);
        $this->assertSame('Chris', array_values($sorted->toArray())[0]['name']);
        $this->assertSame('Tor', array_values($sorted->toArray())[2]['name']);
    }

    public function test_sort_by_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $sorted = $bag->sortBy('age');
        $this->assertSame('Tor', array_values($sorted->toArray())[0]['name']);
        $this->assertSame('Chris', array_values($sorted->toArray())[2]['name']);
    }

    public function test_sort_preserves_keys(): void
    {
        $bag = $this->utility(['b' => 2, 'a' => 1, 'c' => 3]);
        $sorted = $bag->sort();
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $sorted->toArray());
    }

    public function test_sort_returns_new_instance(): void
    {
        $bag = $this->utility([3, 1, 2]);
        $sorted = $bag->sort();
        $this->assertNotSame($bag, $sorted);
        $this->assertSame([3, 1, 2], $bag->toArray());
    }
    public function test_sort_values_ascending(): void
    {
        $bag = $this->utility([3, 1, 4, 1, 5, 9]);
        $this->assertSame([1, 1, 3, 4, 5, 9], array_values($bag->sort()->toArray()));
    }

    public function test_sort_with_custom_callback(): void
    {
        $bag = $this->utility([3, 1, 4, 1, 5]);
        $sorted = $bag->sort(fn (int $a, int $b): int => $b <=> $a);
        $this->assertSame([5, 4, 3, 1, 1], array_values($sorted->toArray()));
    }
}
