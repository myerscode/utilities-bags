<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class RemoveTest extends BaseBagSuite
{
    public function testRemove()
    {
        $bag = $this->utility(['foo', 'bar'])->remove(0)->value();
        $this->assertEquals([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->remove(100)->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->remove('foo')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag);
    }

    public function testOffsetUnset()
    {
        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(0);
        $this->assertEquals([1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(100);
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar']);
        $bag->offsetUnset('foo');
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag->value());
    }
}
