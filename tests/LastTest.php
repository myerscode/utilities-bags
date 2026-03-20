<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class LastTest extends BaseBagSuite
{
    public function test_last_on_single_element_bag(): void
    {
        $this->assertSame(42, $this->utility([42])->last());
    }
    public function test_last_returns_default_when_empty(): void
    {
        $this->assertNull($this->utility([])->last());
        $this->assertSame('fallback', $this->utility([])->last(default: 'fallback'));
    }

    public function test_last_returns_false_when_last_is_false(): void
    {
        $this->assertFalse($this->utility([true, true, false])->last());
    }
    public function test_last_returns_last_item(): void
    {
        $this->assertSame('Chris', $this->utility(['Tor', 'Fred', 'Chris'])->last());
    }

    public function test_last_returns_null_value_when_last_is_null(): void
    {
        $this->assertNull($this->utility(['a', 'b', null])->last());
    }

    public function test_last_returns_zero_when_last_is_zero(): void
    {
        $this->assertSame(0, $this->utility([1, 2, 0])->last());
    }

    public function test_last_with_callback(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame(5, $bag->last(fn (int $value): bool => $value > 3));
    }

    public function test_last_with_callback_receives_key(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(2, $bag->last(fn (int $value, string $key): bool => $key === 'b'));
    }

    public function test_last_with_callback_returns_default_when_no_match(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $this->assertSame('nope', $bag->last(fn (int $value): bool => $value > 10, 'nope'));
    }

    public function test_last_with_mixed_types(): void
    {
        $bag = $this->utility(['hello', 0, false, null]);
        $this->assertSame('hello', $bag->last(fn (mixed $value): bool => is_string($value) && $value !== ''));
    }

    public function test_last_with_nested_arrays(): void
    {
        $bag = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame(['b' => 2], $bag->last());
    }
}
