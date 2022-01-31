<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ToObjectTest extends BaseBagSuite
{
    public function testBagReturnsDataAsArray()
    {
        $this->assertEquals(
            json_decode(json_encode([1, 2, 3]), null, 512, JSON_THROW_ON_ERROR),
            $this->utility([1, 2, 3])->toObject()
        );

        $this->assertEquals(
            json_decode(json_encode(['hello' => 'world']), null, 512, JSON_THROW_ON_ERROR),
            $this->utility(['hello' => 'world'])->toObject()
        );
    }
}
