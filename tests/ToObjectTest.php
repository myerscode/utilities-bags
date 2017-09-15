<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ToObjectTest extends BaseBagSuite
{

    /**
     * Test that toObject returns all the bag data as an object
     *
     * @covers ::toObject
     */
    public function testBagReturnsDataAsArray()
    {
        $this->assertEquals(
            json_decode(json_encode([1, 2, 3])),
            $this->utility([1, 2, 3])->toObject()
        );

        $this->assertEquals(
            json_decode(json_encode(['hello' => 'world'])),
            $this->utility(['hello' => 'world'])->toObject()
        );
    }
}
