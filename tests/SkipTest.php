<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SkipTest extends BaseBagSuite
{
    public function testSkipEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->skip(2)->toArray());
    }

    public function testSkipFirstItems(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([2 => 3, 3 => 4, 4 => 5], $utility->skip(2)->toArray());
    }

    public function testSkipMoreThanCountReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->skip(10)->toArray());
    }

    public function testSkipNegativeKeepsLastItems(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame([3 => 4, 4 => 5], $utility->skip(-2)->toArray());
    }

    public function testSkipPreservesAssociativeKeys(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['b' => 2, 'c' => 3], $utility->skip(1)->toArray());
    }

    public function testSkipReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $skipped = $utility->skip(1);
        $this->assertNotSame($utility, $skipped);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testSkipZeroReturnsAll(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->skip(0)->toArray());
    }
}
