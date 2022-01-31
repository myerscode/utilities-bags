<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class AddTest extends BaseBagSuite
{

    /**
     * @covers ::add
     */
    public function testValueAddedToBag()
    {
        // check can add to empty bag
        $bag = $this->utility([])->add(0, 'foo')->value();
        $this->assertEquals([0 => 'foo'], $bag);

        //check value is not overwritten
        $bag = $this->utility([0 => 'foo'])->add(0, 'bar')->value();
        $this->assertEquals([0 => 'foo'], $bag);

        // check value can be added
        $bag = $this->utility([0 => 'foo'])->add(1, 'bar')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        // check indexes can be mixed
        $bag = $this->utility(['foo' => 'bar'])->add(0, 'foo')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);

        // check can use key index
        $bag = $this->utility([0 => 'foo'])->add('foo', 'bar')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);
    }
}
