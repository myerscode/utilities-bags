<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class UniqueTest extends BaseBagSuite
{
    public function testUniqueOnEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->unique()->toArray());
    }

    public function testUniquePreservesFirstKey(): void
    {
        $bag = $this->utility([1, 2, 2, 3]);
        $this->assertSame([0 => 1, 1 => 2, 3 => 3], $bag->unique()->toArray());
    }
    public function testUniqueRemovesDuplicates(): void
    {
        $bag = $this->utility([1, 2, 2, 3, 3, 3]);
        $this->assertSame([1, 2, 3], array_values($bag->unique()->toArray()));
    }

    public function testUniqueSingleElement(): void
    {
        $this->assertSame([42], $this->utility([42])->unique()->toArray());
    }

    public function testUniqueWithBooleanValues(): void
    {
        $bag = $this->utility([true, false, true, false, true]);
        $this->assertCount(2, $bag->unique());
    }

    public function testUniqueWithCallback(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor', 'role' => 'dev'],
            ['name' => 'Chris', 'role' => 'design'],
        ]);
        $unique = $bag->unique(fn (array $item): string => $item['role']);
        $this->assertCount(2, $unique);
    }

    public function testUniqueWithMixedTypes(): void
    {
        $bag = $this->utility([1, '1', 2, '2', 3]);
        $unique = $bag->unique();
        $this->assertCount(3, $unique);
    }

    public function testUniqueWithNestedArrays(): void
    {
        $bag = $this->utility([['a' => 1], ['a' => 1], ['a' => 2]]);
        $this->assertCount(2, $bag->unique());
    }

    public function testUniqueWithNullValues(): void
    {
        $bag = $this->utility([null, 1, null, 2]);
        $this->assertSame([null, 1, 2], array_values($bag->unique()->toArray()));
    }

    public function testUniqueWithStrings(): void
    {
        $bag = $this->utility(['apple', 'banana', 'apple', 'cherry', 'banana']);
        $this->assertSame(['apple', 'banana', 'cherry'], array_values($bag->unique()->toArray()));
    }
}
