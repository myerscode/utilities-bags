<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReverseTest extends BaseBagSuite
{
    public function testReverseAssociativeWithoutPreserveKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $reversed = $utility->reverse();
        $this->assertSame([3, 2, 1], array_values($reversed->toArray()));
    }

    public function testReverseEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->reverse()->toArray());
    }

    public function testReversePreservesKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['c' => 3, 'b' => 2, 'a' => 1], $utility->reverse(preserveKeys: true)->toArray());
    }

    public function testReverseReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $reversed = $utility->reverse();
        $this->assertNotSame($utility, $reversed);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testReverseSingleElement(): void
    {
        $this->assertSame([42], $this->utility([42])->reverse()->toArray());
    }

    public function testReverseValues(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([3, 2, 1], $utility->reverse()->toArray());
    }

    public function testReverseWithMixedTypes(): void
    {
        $utility = $this->utility([null, 'hello', 42, true]);
        $this->assertSame([true, 42, 'hello', null], $utility->reverse()->toArray());
    }

    public function testReverseWithNestedArrays(): void
    {
        $utility = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame([['b' => 2], ['a' => 1]], $utility->reverse()->toArray());
    }
}
