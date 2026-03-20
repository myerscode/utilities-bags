<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SumTest extends BaseBagSuite
{
    public function test_sum_by_callback(): void
    {
        $bag = $this->utility([
            ['price' => 10, 'qty' => 2],
            ['price' => 5, 'qty' => 3],
        ]);
        $this->assertSame(35, $bag->sum(fn (array $item): int => $item['price'] * $item['qty']));
    }

    public function test_sum_by_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'score' => 10],
            ['name' => 'Tor', 'score' => 20],
            ['name' => 'Chris', 'score' => 30],
        ]);
        $this->assertSame(60, $bag->sum('score'));
    }

    public function test_sum_of_empty_bag(): void
    {
        $this->assertSame(0, $this->utility([])->sum());
    }
    public function test_sum_of_values(): void
    {
        $this->assertSame(15, $this->utility([1, 2, 3, 4, 5])->sum());
    }

    public function test_sum_with_floats(): void
    {
        $this->assertSame(6.6, $this->utility([1.1, 2.2, 3.3])->sum());
    }
}
