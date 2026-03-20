<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class MaxTest extends BaseBagSuite
{
    public function test_max_by_callback(): void
    {
        $bag = $this->utility([
            ['price' => 10],
            ['price' => 5],
            ['price' => 20],
        ]);
        $this->assertSame(20, $bag->max(fn (array $item): int => $item['price']));
    }

    public function test_max_by_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
            ['name' => 'Chris', 'age' => 35],
        ]);
        $this->assertSame(35, $bag->max('age'));
    }

    public function test_max_by_key_with_missing_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'age' => 25],
        ]);
        $this->assertSame(30, $bag->max('age'));
    }

    public function test_max_of_empty_bag_returns_null(): void
    {
        $this->assertNull($this->utility([])->max());
    }
    public function test_max_of_values(): void
    {
        $this->assertSame(9, $this->utility([3, 1, 4, 1, 5, 9])->max());
    }

    public function test_max_single_element(): void
    {
        $this->assertSame(42, $this->utility([42])->max());
    }

    public function test_max_with_floats(): void
    {
        $this->assertSame(3.5, $this->utility([3.5, 0.1, 2.7])->max());
    }

    public function test_max_with_identical_values(): void
    {
        $this->assertSame(5, $this->utility([5, 5, 5])->max());
    }

    public function test_max_with_negative_values(): void
    {
        $this->assertSame(3, $this->utility([3, -5, 1, -2])->max());
    }

    public function test_max_with_strings(): void
    {
        $this->assertSame('cherry', $this->utility(['cherry', 'apple', 'banana'])->max());
    }
}
