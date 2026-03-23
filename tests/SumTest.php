<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SumTest extends BaseBagSuite
{
    public function testSumByCallback(): void
    {
        $utility = $this->utility([
            ['price' => 10, 'qty' => 2],
            ['price' => 5, 'qty' => 3],
        ]);
        $this->assertSame(35, $utility->sum(fn (array $item): int => $item['price'] * $item['qty']));
    }

    public function testSumByKey(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'score' => 10],
            ['name' => 'Tor', 'score' => 20],
            ['name' => 'Chris', 'score' => 30],
        ]);
        $this->assertSame(60, $utility->sum('score'));
    }

    public function testSumByKeyWithMissingKey(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'score' => 10],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'score' => 30],
        ]);
        $this->assertSame(40, $utility->sum('score'));
    }

    public function testSumOfEmptyBag(): void
    {
        $this->assertSame(0, $this->utility([])->sum());
    }

    public function testSumOfValues(): void
    {
        $this->assertSame(15, $this->utility([1, 2, 3, 4, 5])->sum());
    }

    public function testSumSingleElement(): void
    {
        $this->assertSame(42, $this->utility([42])->sum());
    }

    public function testSumWithFloats(): void
    {
        $this->assertEqualsWithDelta(6.6, $this->utility([1.1, 2.2, 3.3])->sum(), PHP_FLOAT_EPSILON);
    }

    public function testSumWithMixedIntAndFloat(): void
    {
        $this->assertEqualsWithDelta(6.5, $this->utility([1, 2.5, 3])->sum(), PHP_FLOAT_EPSILON);
    }

    public function testSumWithNegativeValues(): void
    {
        $this->assertSame(-3, $this->utility([-1, -2, 0])->sum());
    }
}
