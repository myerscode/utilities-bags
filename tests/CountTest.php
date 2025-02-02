<?php

namespace Tests;

use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

class CountTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        return [
            [
                0,
                [],
            ],
            [
                5,
                [1, 2, 3, 4, 5],
            ],
            [
                3,
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            [
                1,
                new BagConstructorTestCase(),
            ],
        ];
    }

    /**
     * Test that bag knows its length
     *
     * @dataProvider __validData
     */
    public function testBagIsCanBeIteratedOver(int $expected, BagConstructorTestCase|array $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->count());
        $this->assertEquals($expected, count($this->utility($bag)));
    }
}
