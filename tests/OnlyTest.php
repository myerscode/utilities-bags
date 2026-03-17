<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class OnlyTest extends BaseBagSuite
{
    public function test_only_returns_array_with_keys_that_are_given(): void
    {
        $utility = $this->utility([
            'foo' => 'bar',
            'hello' => 'world',
            'fluffy' => 'corgi',
            7,
            'rupert',
            49,
            'gerald',
        ]);

        $this->assertSame(['foo' => 'bar', 'fluffy' => 'corgi'], $utility->only(['fluffy', 'foo'])->toArray());
    }
}
