<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ToArrayTest extends BaseBagSuite
{
    /**
     * Test that toArray returns all the bag data as an array
     */
    public function testBagReturnsDataAsArray()
    {
        $this->assertEquals([1, 2, 3], $this->utility([1, 2, 3])->toArray());
        $this->assertEquals(['hello' => 'world'], $this->utility(['hello' => 'world'])->toArray());
    }
}
