<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class IntersectTest extends BaseBagSuite
{
    public function testIntersectAcceptsUtility(): void
    {
        $utility = $this->utility([1, 2, 3, 4]);
        $result = $utility->intersect(new Utility([2, 4, 6]));
        $this->assertSame([1 => 2, 3 => 4], $result->toArray());
    }

    public function testIntersectAllOverlapReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->intersect([1, 2, 3])->toArray());
    }

    public function testIntersectEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->intersect([1, 2])->toArray());
    }

    public function testIntersectEmptyOtherReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->intersect([])->toArray());
    }

    public function testIntersectNoOverlapReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->intersect([4, 5, 6])->toArray());
    }

    public function testIntersectPreservesKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['b' => 2], $utility->intersect([2])->toArray());
    }

    public function testIntersectReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->intersect([2]);
        $this->assertNotSame($utility, $result);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testIntersectValuesPresentInOther(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([1 => 2, 3 => 4], $utility->intersect([2, 4, 9])->toArray());
    }
}
