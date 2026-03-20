<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class RemoveTest extends BaseBagSuite
{
    public function testOffsetUnset(): void
    {
        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(0);
        $this->assertSame([1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(100);
        $this->assertSame([0 => 'foo', 1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar']);
        $bag->offsetUnset('foo');
        $this->assertSame([0 => 'foo', 'hello' => 'world', 1 => 'bar'], $bag->value());
    }

    public function testRemove(): void
    {
        $bag = $this->utility(['foo', 'bar'])->remove(0)->value();
        $this->assertSame([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->remove(100)->value();
        $this->assertSame([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->remove('foo')->value();
        $this->assertSame([0 => 'foo', 'hello' => 'world', 1 => 'bar'], $bag);
    }
}
