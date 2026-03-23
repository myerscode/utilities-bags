<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FirstTest extends BaseBagSuite
{
    public function testFirstOnSingleElementBag(): void
    {
        $this->assertSame(42, $this->utility([42])->first());
    }

    public function testFirstReturnsDefaultWhenEmpty(): void
    {
        $this->assertNull($this->utility([])->first());
        $this->assertSame('fallback', $this->utility([])->first(default: 'fallback'));
    }

    public function testFirstReturnsEmptyStringWhenFirstIsEmptyString(): void
    {
        $this->assertSame('', $this->utility(['', 'a'])->first());
    }

    public function testFirstReturnsFalseWhenFirstIsFalse(): void
    {
        $this->assertFalse($this->utility([false, true, true])->first());
    }

    public function testFirstReturnsFirstItem(): void
    {
        $this->assertSame('Tor', $this->utility(['Tor', 'Fred', 'Chris'])->first());
    }

    public function testFirstReturnsNullValueWhenFirstIsNull(): void
    {
        $this->assertNull($this->utility([null, 'a', 'b'])->first());
    }

    public function testFirstReturnsZeroWhenFirstIsZero(): void
    {
        $this->assertSame(0, $this->utility([0, 1, 2])->first());
    }

    public function testFirstWithCallback(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5]);
        $this->assertSame(4, $utility->first(fn (int $value): bool => $value > 3));
    }

    public function testFirstWithCallbackReceivesKey(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame(2, $utility->first(fn (int $value, string $key): bool => $key === 'b'));
    }

    public function testFirstWithCallbackReturnsDefaultWhenNoMatch(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame('nope', $utility->first(fn (int $value): bool => $value > 10, 'nope'));
    }

    public function testFirstWithMixedTypes(): void
    {
        $utility = $this->utility([null, false, 0, '', 'hello']);
        $this->assertSame('hello', $utility->first(fn (mixed $value): bool => is_string($value) && $value !== ''));
    }

    public function testFirstWithNestedArrays(): void
    {
        $utility = $this->utility([['a' => 1], ['b' => 2]]);
        $this->assertSame(['a' => 1], $utility->first());
    }
}
