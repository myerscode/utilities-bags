<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FirstTest extends BaseBagSuite
{
    public function test_first_returns_default_when_empty(): void
    {
        $this->assertNull($this->utility([])->first());
        $this->assertSame('fallback', $this->utility([])->first(default: 'fallback'));
    }
    public function test_first_returns_first_item(): void
    {
        $this->assertSame('Tor', $this->utility(['Tor', 'Fred', 'Chris'])->first());
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
}
