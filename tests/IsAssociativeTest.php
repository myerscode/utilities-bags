<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class IsAssociativeTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        return [
            [
                true,
                ['foo' => 'bar', 'hello' => 'world'],
            ],
            [
                true,
                ['foo' => ['hello' => 'world']],
            ],
            [
                true,
                ['foo' => ['bar', 'hello', 'world']],
            ],
            [
                true,
                [0 => 'hello', 'one' => 'world'],
            ],
            [
                false,
                [1, 2, 3, 4],
            ],
            [
                false,
                ['foo', 'bar', 'hello', 'world'],
            ],
            [
                false,
                [0 => 'hello', '1' => 'world'],
            ],
            [
                false,
                [['hello' => 'world']],
            ],
            [
                false,
                [],
            ],
        ];
    }

    /**
     * Test that isAssociative returns true if the bag is an associative array
     *
     * @dataProvider __validData
     */
    public function testBagIsAssociative(bool $expected, array $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->isAssociative());
    }
}
