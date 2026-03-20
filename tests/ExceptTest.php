<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ExceptTest extends BaseBagSuite
{
    public function testExceptReturnsArrayWithKeysThatAreNotGiven(): void
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

        $this->assertSame([
            'hello' => 'world',
            7,
            'rupert',
            49,
            'gerald',
        ], $utility->except(['fluffy', 'foo'])->toArray());
    }
}
