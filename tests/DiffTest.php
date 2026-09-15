<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class DiffTest extends BaseBagSuite
{
    public function testDiffAcceptsUtility(): void
    {
        $utility = $this->utility([1, 2, 3, 4]);
        $result = $utility->diff(new Utility([2, 4]));
        $this->assertSame([0 => 1, 2 => 3], $result->toArray());
    }

    public function testDiffAllOverlapReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->diff([1, 2, 3])->toArray());
    }

    public function testDiffEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->diff([1, 2])->toArray());
    }

    public function testDiffEmptyOtherReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->diff([])->toArray());
    }

    public function testDiffNoOverlapReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->diff([4, 5, 6])->toArray());
    }

    public function testDiffPreservesKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['a' => 1, 'c' => 3], $utility->diff([2])->toArray());
    }

    public function testDiffReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->diff([2]);
        $this->assertNotSame($utility, $result);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testDiffValuesNotInOther(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([0 => 1, 2 => 3, 4 => 5], $utility->diff([2, 4])->toArray());
    }
}
