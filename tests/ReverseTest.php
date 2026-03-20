<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReverseTest extends BaseBagSuite
{
    public function test_reverse_associative_without_preserve_keys(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $reversed = $bag->reverse();
        $this->assertSame([3, 2, 1], array_values($reversed->toArray()));
    }
    public function test_reverse_empty_bag(): void
    {
        $this->assertSame([], $this->utility([])->reverse()->toArray());
    }

    public function test_reverse_preserves_keys(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(['c' => 3, 'b' => 2, 'a' => 1], $bag->reverse(preserveKeys: true)->toArray());
    }

    public function test_reverse_returns_new_instance(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $reversed = $bag->reverse();
        $this->assertNotSame($bag, $reversed);
        $this->assertSame([1, 2, 3], $bag->toArray());
    }

    public function test_reverse_single_element(): void
    {
        $this->assertSame([42], $this->utility([42])->reverse()->toArray());
    }
    public function test_reverse_values(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $this->assertSame([3, 2, 1], $bag->reverse()->toArray());
    }

    public function test_reverse_with_mixed_types(): void
    {
        $bag = $this->utility([null, 'hello', 42, true]);
        $this->assertSame([true, 42, 'hello', null], $bag->reverse()->toArray());
    }

    public function test_reverse_with_nested_arrays(): void
    {
        $bag = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame([['b' => 2], ['a' => 1]], $bag->reverse()->toArray());
    }
}
