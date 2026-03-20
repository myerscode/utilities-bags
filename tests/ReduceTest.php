<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReduceTest extends BaseBagSuite
{
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

    public function test_reduce_with_null_initial(): void
    {
        $result = $this->utility([1, 2, 3])->reduce(fn (?int $carry, int $item): int => ($carry ?? 0) + $item);
        $this->assertSame(6, $result);
    }
}
