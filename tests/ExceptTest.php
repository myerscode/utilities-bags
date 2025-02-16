<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ExceptTest extends BaseBagSuite
{
    public function test_except_returns_array_with_keys_that_are_not_given(): void
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
