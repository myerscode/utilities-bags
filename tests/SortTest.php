<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SortTest extends BaseBagSuite
{
    public function testSortByCallback(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $sorted = $bag->sortBy(fn (array $item): int => $item['age']);
        $this->assertSame('Tor', array_values($sorted->toArray())[0]['name']);
    }

    public function testSortByDescending(): void
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

    public function testSortByKey(): void
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

    public function testSortByStringValues(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred'],
            ['name' => 'Alice'],
            ['name' => 'Tor'],
        ]);
        $sorted = $bag->sortBy('name');
        $values = array_values($sorted->toArray());
        $this->assertSame('Alice', $values[0]['name']);
        $this->assertSame('Fred', $values[1]['name']);
        $this->assertSame('Tor', $values[2]['name']);
    }

    public function testSortByWithMissingKeyInSomeItems(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'age' => 25],
        ]);
        $sorted = $bag->sortBy('age');
        $values = array_values($sorted->toArray());
        $this->assertSame('Tor', $values[0]['name']);
        $this->assertSame('Chris', $values[1]['name']);
        $this->assertSame('Fred', $values[2]['name']);
    }

    public function testSortEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->sort()->toArray());
    }

    public function testSortPreservesKeys(): void
    {
        $bag = $this->utility(['b' => 2, 'a' => 1, 'c' => 3]);
        $sorted = $bag->sort();
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $sorted->toArray());
    }

    public function testSortReturnsNewInstance(): void
    {
        $bag = $this->utility([3, 1, 2]);
        $sorted = $bag->sort();
        $this->assertNotSame($bag, $sorted);
        $this->assertSame([3, 1, 2], $bag->toArray());
    }

    public function testSortSingleElement(): void
    {
        $this->assertSame([42], $this->utility([42])->sort()->toArray());
    }
    public function testSortValuesAscending(): void
    {
        $bag = $this->utility([3, 1, 4, 1, 5, 9]);
        $this->assertSame([1, 1, 3, 4, 5, 9], array_values($bag->sort()->toArray()));
    }

    public function testSortWithCustomCallback(): void
    {
        $bag = $this->utility([3, 1, 4, 1, 5]);
        $sorted = $bag->sort(fn (int $a, int $b): int => $b <=> $a);
        $this->assertSame([5, 4, 3, 1, 1], array_values($sorted->toArray()));
    }

    public function testSortWithMixedNumericTypes(): void
    {
        $bag = $this->utility([3.5, 1, 2.1, 4]);
        $sorted = array_values($bag->sort()->toArray());
        $this->assertSame(1, $sorted[0]);
        $this->assertSame(2.1, $sorted[1]);
        $this->assertSame(3.5, $sorted[2]);
        $this->assertSame(4, $sorted[3]);
    }

    public function testSortWithStrings(): void
    {
        $bag = $this->utility(['banana', 'apple', 'cherry']);
        $this->assertSame(['apple', 'banana', 'cherry'], array_values($bag->sort()->toArray()));
    }
}
