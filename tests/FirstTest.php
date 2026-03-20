<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FirstTest extends BaseBagSuite
{
    public function test_first_on_single_element_bag(): void
    {
        $this->assertSame(42, $this->utility([42])->first());
    }
    public function test_first_returns_default_when_empty(): void
    {
        $this->assertNull($this->utility([])->first());
        $this->assertSame('fallback', $this->utility([])->first(default: 'fallback'));
    }

    public function test_first_returns_empty_string_when_first_is_empty_string(): void
    {
        $this->assertSame('', $this->utility(['', 'a'])->first());
    }

    public function test_first_returns_false_when_first_is_false(): void
    {
        $this->assertFalse($this->utility([false, true, true])->first());
    }
    public function test_first_returns_first_item(): void
    {
        $this->assertSame('Tor', $this->utility(['Tor', 'Fred', 'Chris'])->first());
    }

    public function test_first_returns_null_value_when_first_is_null(): void
    {
        $this->assertNull($this->utility([null, 'a', 'b'])->first());
    }

    public function test_first_returns_zero_when_first_is_zero(): void
    {
        $this->assertSame(0, $this->utility([0, 1, 2])->first());
    }

    public function test_first_with_callback(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame(4, $bag->first(fn (int $value): bool => $value > 3));
    }

    public function test_first_with_callback_receives_key(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(2, $bag->first(fn (int $value, string $key): bool => $key === 'b'));
    }

    public function test_first_with_callback_returns_default_when_no_match(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $this->assertSame('nope', $bag->first(fn (int $value): bool => $value > 10, 'nope'));
    }

    public function test_first_with_mixed_types(): void
    {
        $bag = $this->utility([null, false, 0, '', 'hello']);
        $this->assertSame('hello', $bag->first(fn (mixed $value): bool => is_string($value) && $value !== ''));
    }

    public function test_first_with_nested_arrays(): void
    {
        $bag = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame(['a' => 1], $bag->first());
    }
}
