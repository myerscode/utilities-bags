<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class PushTest extends BaseBagSuite
{

    /**
     * @covers ::push
     */
    public function testValueAddedToBag()
    {
        $bag = $this->utility([])->push('foo')->value();
        $this->assertEquals(['foo'], $bag);

        $bag = $this->utility([])->push('foo', 'bar', 'hello', 'world')->value();
        $this->assertEquals(['foo', 'bar', 'hello', 'world'], $bag);

        $bag = $this->utility(['foo'])->push('bar')->value();
        $this->assertEquals(['foo', 'bar'], $bag);

        $bag = $this->utility([1 => 'foo'])->push('bar')->value();
        $this->assertEquals([1 => 'foo', 2 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar'])->push('hello')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'hello'], $bag);
    }
}