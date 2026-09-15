<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SliceTest extends BaseBagSuite
{
    public function testSliceEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->slice(0, 2)->toArray());
    }

    public function testSliceFromOffset(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([2 => 3, 3 => 4, 4 => 5], $utility->slice(2)->toArray());
    }

    public function testSliceNegativeLength(): void
    {
        // stops the slice that many items from the end
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([1 => 2, 2 => 3], $utility->slice(1, -2)->toArray());
    }

    public function testSliceNegativeOffset(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([3 => 4, 4 => 5], $utility->slice(-2)->toArray());
    }

    public function testSliceOffsetBeyondEndReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->slice(10)->toArray());
    }

    public function testSlicePreservesAssociativeKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->assertSame(['b' => 2, 'c' => 3], $utility->slice(1, 2)->toArray());
    }

    public function testSliceReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $sliced = $utility->slice(1);
        $this->assertNotSame($utility, $sliced);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testSliceWithOffsetAndLength(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([1 => 2, 2 => 3], $utility->slice(1, 2)->toArray());
    }
}
