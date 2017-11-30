<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class SetTest extends BaseBagSuite
{

    /**
     * @covers ::set
     */
    public function testValueSetToBagViaSet()
    {
        // check can add to empty bag
        $bag = $this->utility([])->set(0, 'foo')->value();
        $this->assertEquals([0 => 'foo'], $bag);

        //check value is not overwritten
        $bag = $this->utility([0 => 'foo'])->set(0, 'bar')->value();
        $this->assertEquals([0 => 'bar'], $bag);

        // check value can be added
        $bag = $this->utility([0 => 'foo'])->set(1, 'bar')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        // check indexes can be mixed
        $bag = $this->utility(['foo' => 'bar'])->set(0, 'foo')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);

        // check can use key index
        $bag = $this->utility([0 => 'foo'])->set('foo', 'bar')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);
    }

    /**
     * @covers ::offsetSet
     */
    public function testValueSetToBagViaOffsetSet()
    {
        // check can add to empty bag
        $bag = $this->utility([])->offsetSet(0, 'foo')->value();
        $this->assertEquals([0 => 'foo'], $bag);

        //check value is not overwritten
        $bag = $this->utility([0 => 'foo'])->offsetSet(0, 'bar')->value();
        $this->assertEquals([0 => 'bar'], $bag);

        // check value can be added
        $bag = $this->utility([0 => 'foo'])->offsetSet(1, 'bar')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        // check indexes can be mixed
        $bag = $this->utility(['foo' => 'bar'])->offsetSet(0, 'foo')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);

        // check can use key index
        $bag = $this->utility([0 => 'foo'])->offsetSet('foo', 'bar')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);
    }
}