<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class CollapseTest extends BaseBagSuite
{
    public function testCollapseBagOfArrays(): void
    {
        $utility = $this->utility([[1, 2], [3, 4], [5]]);
        $this->assertSame([1, 2, 3, 4, 5], $utility->collapse()->toArray());
    }

    public function testCollapseBagOfBags(): void
    {
        $utility = $this->utility([new Utility([1, 2]), new Utility([3, 4])]);
        $this->assertSame([1, 2, 3, 4], $utility->collapse()->toArray());
    }

    public function testCollapseEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->collapse()->toArray());
    }

    public function testCollapseKeepsScalarValues(): void
    {
        $utility = $this->utility([[1, 2], 3, [4]]);
        $this->assertSame([1, 2, 3, 4], $utility->collapse()->toArray());
    }

    public function testCollapseOnlyGoesOneLevel(): void
    {
        $utility = $this->utility([[[1, 2]], [[3]]]);
        $this->assertSame([[1, 2], [3]], $utility->collapse()->toArray());
    }

    public function testCollapseReturnsNewInstance(): void
    {
        $utility = $this->utility([[1], [2]]);
        $collapsed = $utility->collapse();
        $this->assertNotSame($utility, $collapsed);
        $this->assertSame([[1], [2]], $utility->toArray());
    }
}
