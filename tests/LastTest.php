<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class LastTest extends BaseBagSuite
{
    public function testLastOnSingleElementBag(): void
    {
        $this->assertSame(42, $this->utility([42])->last());
    }
    public function testLastReturnsDefaultWhenEmpty(): void
    {
        $this->assertNull($this->utility([])->last());
        $this->assertSame('fallback', $this->utility([])->last(default: 'fallback'));
    }

    public function testLastReturnsFalseWhenLastIsFalse(): void
    {
        $this->assertFalse($this->utility([true, true, false])->last());
    }
    public function testLastReturnsLastItem(): void
    {
        $this->assertSame('Chris', $this->utility(['Tor', 'Fred', 'Chris'])->last());
    }

    public function testLastReturnsNullValueWhenLastIsNull(): void
    {
        $this->assertNull($this->utility(['a', 'b', null])->last());
    }

    public function testLastReturnsZeroWhenLastIsZero(): void
    {
        $this->assertSame(0, $this->utility([1, 2, 0])->last());
    }

    public function testLastWithCallback(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame(5, $bag->last(fn (int $value): bool => $value > 3));
    }

    public function testLastWithCallbackReceivesKey(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(2, $bag->last(fn (int $value, string $key): bool => $key === 'b'));
    }

    public function testLastWithCallbackReturnsDefaultWhenNoMatch(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $this->assertSame('nope', $bag->last(fn (int $value): bool => $value > 10, 'nope'));
    }

    public function testLastWithMixedTypes(): void
    {
        $bag = $this->utility(['hello', 0, false, null]);
        $this->assertSame('hello', $bag->last(fn (mixed $value): bool => is_string($value) && $value !== ''));
    }

    public function testLastWithNestedArrays(): void
    {
        $bag = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame(['b' => 2], $bag->last());
    }
}
