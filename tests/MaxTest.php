<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class MaxTest extends BaseBagSuite
{
    public function testMaxByCallback(): void
    {
        $bag = $this->utility([
            ['price' => 10],
            ['price' => 5],
            ['price' => 20],
        ]);
        $this->assertSame(20, $bag->max(fn (array $item): int => $item['price']));
    }

    public function testMaxByKey(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $this->assertSame(35, $bag->max('age'));
    }

    public function testMaxByKeyWithMissingKey(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'age' => 25],
        ]);
        $this->assertSame(30, $bag->max('age'));
    }

    public function testMaxOfEmptyBagReturnsNull(): void
    {
        $this->assertNull($this->utility([])->max());
    }
    public function testMaxOfValues(): void
    {
        $this->assertSame(9, $this->utility([3, 1, 4, 1, 5, 9])->max());
    }

    public function testMaxSingleElement(): void
    {
        $this->assertSame(42, $this->utility([42])->max());
    }

    public function testMaxWithFloats(): void
    {
        $this->assertSame(3.5, $this->utility([3.5, 0.1, 2.7])->max());
    }

    public function testMaxWithIdenticalValues(): void
    {
        $this->assertSame(5, $this->utility([5, 5, 5])->max());
    }

    public function testMaxWithNegativeValues(): void
    {
        $this->assertSame(3, $this->utility([3, -5, 1, -2])->max());
    }

    public function testMaxWithStrings(): void
    {
        $this->assertSame('cherry', $this->utility(['cherry', 'apple', 'banana'])->max());
    }
}
