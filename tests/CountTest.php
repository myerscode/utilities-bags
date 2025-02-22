<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
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
                new BagConstructorTestCase,
            ],
        ];
    }

    /**
     * Test that bag knows its length
     */
    #[DataProvider('__validData')]
    public function test_bag_is_can_be_iterated_over(int $expected, BagConstructorTestCase|array $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->count());
        $this->assertEquals($expected, count($this->utility($bag)));
    }
}
