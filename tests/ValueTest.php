<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ValueTest extends BaseBagSuite
{
    /**
     * Test that value returns all the bag data as an array
     */
    public function testValueReturnsDataAsArray(): void
    {
        $this->assertEquals([1, 2, 3], $this->utility([1, 2, 3])->value());
        $this->assertEquals(['hello' => 'world'], $this->utility(['hello' => 'world'])->value());
    }
}
