<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class TakeTest extends BaseBagSuite
{
    public function testTakeEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->take(3)->toArray());
    }

    public function testTakeFirstItems(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([1, 2, 3], $utility->take(3)->toArray());
    }

    public function testTakeLastItemsWithNegativeLimit(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([3 => 4, 4 => 5], $utility->take(-2)->toArray());
    }

    public function testTakeMoreThanCountReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->take(10)->toArray());
    }

    public function testTakeNegativeMoreThanCountReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->take(-10)->toArray());
    }

    public function testTakePreservesAssociativeKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['a' => 1, 'b' => 2], $utility->take(2)->toArray());
    }

    public function testTakeReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $taken = $utility->take(2);
        $this->assertNotSame($utility, $taken);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testTakeZeroReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->take(0)->toArray());
    }
}
