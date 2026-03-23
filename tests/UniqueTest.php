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
        $utility = $this->utility([1, 2, 2, 3]);
        $this->assertSame([0 => 1, 1 => 2, 3 => 3], $utility->unique()->toArray());
    }

    public function testUniqueRemovesDuplicates(): void
    {
        $utility = $this->utility([1, 2, 2, 3, 3, 3]);
        $this->assertSame([1, 2, 3], array_values($utility->unique()->toArray()));
    }

    public function testUniqueSingleElement(): void
    {
        $this->assertSame([42], $this->utility([42])->unique()->toArray());
    }

    public function testUniqueWithBooleanValues(): void
    {
        $utility = $this->utility([true, false, true, false, true]);
        $this->assertCount(2, $utility->unique());
    }

    public function testUniqueWithCallback(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor', 'role' => 'dev'],
            ['name' => 'Chris', 'role' => 'design'],
        ]);
        $unique = $utility->unique(fn (array $item): string => $item['role']);
        $this->assertCount(2, $unique);
    }

    public function testUniqueWithMixedTypes(): void
    {
        $utility = $this->utility([1, '1', 2, '2', 3]);
        $unique = $utility->unique();
        $this->assertCount(3, $unique);
    }

    public function testUniqueWithNestedArrays(): void
    {
        $utility = $this->utility([['a' => 1], ['a' => 1], ['a' => 2]]);
        $this->assertCount(2, $utility->unique());
    }

    public function testUniqueWithNullValues(): void
    {
        $utility = $this->utility([null, 1, null, 2]);
        $this->assertSame([null, 1, 2], array_values($utility->unique()->toArray()));
    }

    public function testUniqueWithStrings(): void
    {
        $utility = $this->utility(['apple', 'banana', 'apple', 'cherry', 'banana']);
        $this->assertSame(['apple', 'banana', 'cherry'], array_values($utility->unique()->toArray()));
    }
}
