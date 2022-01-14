<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ToObjectTest extends BaseBagSuite
{
    /**
     * Test that toObject returns all the bag data as an object
     */
    public function testBagReturnsDataAsObject()
    {
        $this->assertEquals(
            json_decode(json_encode((object) [1, 2, 3])),
            $this->utility([1, 2, 3])->toObject()
        );

        $this->assertEquals(
            json_decode(json_encode(['hello' => 'world', 'fee' => ['fii' => ['foo' => ['fum']]]])),
            $this->utility((object) ['hello' => 'world', 'fee' => ['fii' => ['foo' => ['fum']]]])->toObject()
        );
    }
}
