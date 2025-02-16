<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class OnlyTest extends BaseBagSuite
{
    public function test_only_returns_array_with_keys_that_are_given(): void
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
