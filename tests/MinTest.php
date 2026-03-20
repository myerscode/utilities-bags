<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class MinTest extends BaseBagSuite
{
    public function test_min_by_callback(): void
    {
        $bag = $this->utility([
            ['price' => 10],
            ['price' => 5],
            ['price' => 20],
        ]);
        $this->assertSame(5, $bag->min(fn (array $item): int => $item['price']));
    }

    public function test_min_by_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $this->assertSame(25, $bag->min('age'));
    }

    public function test_min_by_key_with_missing_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'age' => 25],
        ]);
        $this->assertNull($bag->min('age'));
    }

    public function test_min_of_empty_bag_returns_null(): void
    {
        $this->assertNull($this->utility([])->min());
    }
    public function test_min_of_values(): void
    {
        $this->assertSame(1, $this->utility([3, 1, 4, 1, 5])->min());
    }

    public function test_min_single_element(): void
    {
        $this->assertSame(42, $this->utility([42])->min());
    }

    public function test_min_with_floats(): void
    {
        $this->assertSame(0.1, $this->utility([3.5, 0.1, 2.7])->min());
    }

    public function test_min_with_identical_values(): void
    {
        $this->assertSame(5, $this->utility([5, 5, 5])->min());
    }

    public function test_min_with_negative_values(): void
    {
        $this->assertSame(-5, $this->utility([3, -5, 1, -2])->min());
    }

    public function test_min_with_strings(): void
    {
        $this->assertSame('apple', $this->utility(['cherry', 'apple', 'banana'])->min());
    }
}
