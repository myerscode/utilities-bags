<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReduceTest extends BaseBagSuite
{
    public function test_reduce_builds_associative_array(): void
    {
        $bag = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 2, 'name' => 'Tor'],
        ]);
        $result = $bag->reduce(fn (array $carry, array $item): array => $carry + [$item['id'] => $item['name']], []);
        $this->assertSame([1 => 'Fred', 2 => 'Tor'], $result);
    }
    public function test_reduce_concatenates_strings(): void
    {
        $result = $this->utility(['a', 'b', 'c'])->reduce(fn (string $carry, string $item): string => $carry . $item, '');
        $this->assertSame('abc', $result);
    }

    public function test_reduce_on_empty_bag_returns_initial(): void
    {
        $result = $this->utility([])->reduce(fn (int $carry, int $item): int => $carry + $item, 42);
        $this->assertSame(42, $result);
    }
    public function test_reduce_sums_values(): void
    {
        $result = $this->utility([1, 2, 3, 4, 5])->reduce(fn (int $carry, int $item): int => $carry + $item, 0);
        $this->assertSame(15, $result);
    }

    public function test_reduce_with_mixed_types(): void
    {
        $bag = $this->utility(['a', 1, true, null]);
        $result = $bag->reduce(fn (array $carry, mixed $item): array => [...$carry, gettype($item)], []);
        $this->assertSame(['string', 'integer', 'boolean', 'NULL'], $result);
    }

    public function test_reduce_with_nested_arrays(): void
    {
        $bag = $this->utility([[1, 2], [3, 4], [5]]);
        $result = $bag->reduce(fn (array $carry, array $item): array => [...$carry, ...$item], []);
        $this->assertSame([1, 2, 3, 4, 5], $result);
    }

    public function test_reduce_with_null_initial(): void
    {
        $result = $this->utility([1, 2, 3])->reduce(fn (?int $carry, int $item): int => ($carry ?? 0) + $item);
        $this->assertSame(6, $result);
    }
}
