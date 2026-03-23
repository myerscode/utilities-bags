<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class MinTest extends BaseBagSuite
{
    public function testMinByCallback(): void
    {
        $utility = $this->utility([
            ['price' => 10],
            ['price' => 5],
            ['price' => 20],
        ]);
        $this->assertSame(5, $utility->min(fn (array $item): int => $item['price']));
    }

    public function testMinByKey(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $this->assertSame(25, $utility->min('age'));
    }

    public function testMinByKeyWithMissingKey(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'age' => 25],
        ]);
        $this->assertNull($utility->min('age'));
    }

    public function testMinOfEmptyBagReturnsNull(): void
    {
        $this->assertNull($this->utility([])->min());
    }

    public function testMinOfValues(): void
    {
        $this->assertSame(1, $this->utility([3, 1, 4, 1, 5])->min());
    }

    public function testMinSingleElement(): void
    {
        $this->assertSame(42, $this->utility([42])->min());
    }

    public function testMinWithFloats(): void
    {
        $this->assertEqualsWithDelta(0.1, $this->utility([3.5, 0.1, 2.7])->min(), PHP_FLOAT_EPSILON);
    }

    public function testMinWithIdenticalValues(): void
    {
        $this->assertSame(5, $this->utility([5, 5, 5])->min());
    }

    public function testMinWithNegativeValues(): void
    {
        $this->assertSame(-5, $this->utility([3, -5, 1, -2])->min());
    }

    public function testMinWithStrings(): void
    {
        $this->assertSame('apple', $this->utility(['cherry', 'apple', 'banana'])->min());
    }
}
