<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ToObjectTest extends BaseBagSuite
{
    /**
     * Test that toObject returns all the bag data as an object
     */
    public function test_bag_returns_data_as_object(): void
    {
        $this->assertEquals(
            json_decode(json_encode((object) [1, 2, 3], JSON_THROW_ON_ERROR), null, 512, JSON_THROW_ON_ERROR),
            $this->utility([1, 2, 3])->toObject()
        );

        $this->assertEquals(
            json_decode(json_encode(['hello' => 'world', 'fee' => ['fii' => ['foo' => ['fum']]]]), null, 512, JSON_THROW_ON_ERROR),
            $this->utility((object) ['hello' => 'world', 'fee' => ['fii' => ['foo' => ['fum']]]])->toObject()
        );
    }
}
