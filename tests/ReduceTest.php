<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReduceTest extends BaseBagSuite
{
    public function testReduceBuildsAssociativeArray(): void
    {
        $bag = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 2, 'name' => 'Tor'],
        ]);
        $result = $bag->reduce(fn (array $carry, array $item): array => $carry + [$item['id'] => $item['name']], []);
        $this->assertSame([1 => 'Fred', 2 => 'Tor'], $result);
    }
    public function testReduceConcatenatesStrings(): void
    {
        $result = $this->utility(['a', 'b', 'c'])->reduce(fn (string $carry, string $item): string => $carry . $item, '');
        $this->assertSame('abc', $result);
    }

    public function testReduceOnEmptyBagReturnsInitial(): void
    {
        $result = $this->utility([])->reduce(fn (int $carry, int $item): int => $carry + $item, 42);
        $this->assertSame(42, $result);
    }
    public function testReduceSumsValues(): void
    {
        $result = $this->utility([1, 2, 3, 4, 5])->reduce(fn (int $carry, int $item): int => $carry + $item, 0);
        $this->assertSame(15, $result);
    }

    public function testReduceWithMixedTypes(): void
    {
        $bag = $this->utility(['a', 1, true, null]);
        $result = $bag->reduce(fn (array $carry, mixed $item): array => [...$carry, gettype($item)], []);
        $this->assertSame(['string', 'integer', 'boolean', 'NULL'], $result);
    }

    public function testReduceWithNestedArrays(): void
    {
        $bag = $this->utility([[1, 2], [3, 4], [5]]);
        $result = $bag->reduce(fn (array $carry, array $item): array => [...$carry, ...$item], []);
        $this->assertSame([1, 2, 3, 4, 5], $result);
    }

    public function testReduceWithNullInitial(): void
    {
        $result = $this->utility([1, 2, 3])->reduce(fn (?int $carry, int $item): int => ($carry ?? 0) + $item);
        $this->assertSame(6, $result);
    }
}
