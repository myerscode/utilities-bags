<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class RemoveTest extends BaseBagSuite
{
    public function testOffsetUnset()
    {
        $bag = $this->utility(['foo', 'bar'])->offsetUnset(0)->value();
        $this->assertEquals([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->offsetUnset(100)->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->offsetUnset('foo')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag);
    }

    public function testRemove()
    {
        $bag = $this->utility(['foo', 'bar'])->remove(0)->value();
        $this->assertEquals([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->remove(100)->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->remove('foo')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag);
    }
}
