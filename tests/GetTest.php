<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class GetTest extends BaseBagSuite
{

    /**
     * @covers ::get
     */
    public function testValueRetrievedFromGet()
    {
        $this->assertEquals(null, $this->utility([])->get(100));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->get(2));

        $this->assertEquals('foo', $this->utility(['foo', 'bar'])->get(0));

        $this->assertEquals('world', $this->utility(['foo' => 'bar', 'hello' => 'world'])->get('hello'));

        $this->assertEquals('whoops', $this->utility(['foo', 'bar'])->get(2, 'whoops'));
    }

    /**
     * @covers ::offsetGet
     */
    public function testValueRetrievedFromOffsetGet()
    {
        $this->assertEquals(null, $this->utility([])->offsetGet(100));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->offsetGet(2));

        $this->assertEquals('foo', $this->utility(['foo', 'bar'])->offsetGet(0));

        $this->assertEquals('world', $this->utility(['foo' => 'bar', 'hello' => 'world'])->offsetGet('hello'));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->offsetGet(2));

    }
}