<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ReverseTest extends BaseBagSuite
{
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
    public function test_reverse_values(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $this->assertSame([3, 2, 1], $bag->reverse()->toArray());
    }
}
