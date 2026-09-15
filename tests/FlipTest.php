<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FlipTest extends BaseBagSuite
{
    public function testFlipAssociativeBag(): void
    {
        $utility = $this->utility(['a' => 'x', 'b' => 'y', 'c' => 'z']);
        $this->assertSame(['x' => 'a', 'y' => 'b', 'z' => 'c'], $utility->flip()->toArray());
    }

    public function testFlipDuplicateValuesKeepLast(): void
    {
        $utility = $this->utility(['a' => 'x', 'b' => 'x', 'c' => 'y']);
        $this->assertSame(['x' => 'b', 'y' => 'c'], $utility->flip()->toArray());
    }

    public function testFlipEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->flip()->toArray());
    }

    public function testFlipReturnsNewInstance(): void
    {
        $utility = $this->utility(['a' => 'x']);
        $flipped = $utility->flip();
        $this->assertNotSame($utility, $flipped);
        $this->assertSame(['a' => 'x'], $utility->toArray());
    }

    public function testFlipSequentialBag(): void
    {
        $utility = $this->utility(['foo', 'bar', 'baz']);
        $this->assertSame(['foo' => 0, 'bar' => 1, 'baz' => 2], $utility->flip()->toArray());
    }

    public function testFlipSingleElement(): void
    {
        $this->assertSame(['foo' => 0], $this->utility(['foo'])->flip()->toArray());
    }
}
