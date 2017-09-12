<?php

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ConstructTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            [
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5]
            ],
            [
                ['1', '2', '3', '4', '5'],
                ['1', '2', '3', '4', '5']
            ],
            [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => '']
            ],
            [
                ['1', '2', '3', '4', '5'],
                json_decode(json_encode([1, 2, 3, 4, 5]), false)
            ],
            [
                [],
                new \stdClass()
            ],
            [
                [],
                []
            ],
        ];
    }

    /**
     * Test that the constructor takes value and sets it internally
     *
     * @param array $expected The value expected to be returned
     * @param mixed $bag The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::__construct
     */
    public function testBagIsSetViaConstructor($expected, $bag)
    {
        $this->assertEquals($expected, $this->utility($bag)->value());
    }

    /**
     * Test that the static make method takes value and sets it internally
     *
     * @param array $expected The value expected to be returned
     * @param mixed $bag The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::make
     */
    public function testBagIsSetViaMake($expected, $bag)
    {
        $this->assertEquals($expected, Utility::make($bag)->value());
    }

}
