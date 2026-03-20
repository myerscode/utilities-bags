<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class LastTest extends BaseBagSuite
{
    public function test_last_returns_default_when_empty(): void
    {
        $this->assertNull($this->utility([])->last());
        $this->assertSame('fallback', $this->utility([])->last(default: 'fallback'));
    }
    public function test_last_returns_last_item(): void
    {
        $this->assertSame('Chris', $this->utility(['Tor', 'Fred', 'Chris'])->last());
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
}
