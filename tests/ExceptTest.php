<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ExceptTest extends BaseBagSuite
{

    public function testExceptReturnsArrayWithKeysThatAreNotGiven(): void
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

        $this->assertEquals([
            'hello' => 'world',
            7,
            'rupert',
            49,
            'gerald',
        ], $bag->except(['fluffy', 'foo'])->toArray());
    }
}
