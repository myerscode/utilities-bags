<?php

namespace Tests;

use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class CountTest extends BaseBagSuite
{

    public function dataProvider()
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
     * @param  mixed  $expected  The expected result
     * @param  mixed  $bag  The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::count
     */
    public function testBagIsCanBeIteratedOver($expected, $bag)
    {
        $this->assertEquals($expected, $this->utility($bag)->count());
        $this->assertEquals($expected, count($this->utility($bag)));
    }

}
