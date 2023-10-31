<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class OnlyTest extends BaseBagSuite
{

    public function testOnlyReturnsArrayWithKeysThatAreGiven()
    {
        $bag = $this->utility([
            'foo' => 'bar',
            'hello' => 'world',
            'fluffy' => 'corgi',
            7,
            'rupert',
            49,
            'gerald',
        ]);

        $this->assertEquals(['fluffy' => 'corgi', 'foo' => 'bar'], $bag->only(['fluffy', 'foo'])->toArray());
    }
}
