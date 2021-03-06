<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class RemoveTest extends BaseBagSuite
{

    /**
     * @covers ::remove
     */
    public function testRemove()
    {
        $bag = $this->utility(['foo', 'bar'])->remove(0)->value();
        $this->assertEquals([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->remove(100)->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->remove('foo')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag);

    }

    /**
     * @covers ::offsetUnset
     */
    public function testOffsetUnset()
    {
        $bag = $this->utility(['foo', 'bar'])->offsetUnset(0)->value();
        $this->assertEquals([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->offsetUnset(100)->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->offsetUnset('foo')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar', 'hello' => 'world',], $bag);

    }
}