<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FlatMapTest extends BaseBagSuite
{
    public function testFlatMapEmptyBag(): void
    {
        $result = $this->utility([])->flatMap(fn (mixed $value): array => [$value]);
        $this->assertSame([], $result->toArray());
    }

    public function testFlatMapFlattensArrayResultsOneLevel(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->flatMap(fn (int $value): array => [$value, $value * 10]);
        $this->assertSame([1, 10, 2, 20, 3, 30], $result->toArray());
    }

    public function testFlatMapOnlyFlattensOneLevel(): void
    {
        $utility = $this->utility([1, 2]);
        $result = $utility->flatMap(fn (int $value): array => [[$value]]);
        $this->assertSame([[1], [2]], $result->toArray());
    }

    public function testFlatMapReceivesKey(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2]);
        $result = $utility->flatMap(fn (int $value, string $key): array => [$key, $value]);
        $this->assertSame(['a', 1, 'b', 2], $result->toArray());
    }

    public function testFlatMapReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2]);
        $result = $utility->flatMap(fn (int $value): array => [$value]);
        $this->assertNotSame($utility, $result);
        $this->assertSame([1, 2], $utility->toArray());
    }

    public function testFlatMapWithScalarResults(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->flatMap(fn (int $value): int => $value * 2);
        $this->assertSame([2, 4, 6], $result->toArray());
    }
}
