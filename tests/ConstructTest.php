<?php

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use stdClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ConstructTest extends BaseBagSuite
{

    public function dataProvider()
    {
        $bagConstructorTestCase = new BagConstructorTestCase();

        return [
            [
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            [
                [1],
                1,
            ],
            [
                ['1', '2', '3', '4', '5'],
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['2'],
                '2',
            ],
            [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            [
                ['1', '2', '3', '4', '5'],
                json_decode(json_encode([1, 2, 3, 4, 5]), false, 512, JSON_THROW_ON_ERROR),
            ],
            [
                [],
                new stdClass(),
            ],
            [
                [],
                [],
            ],
            [
                [
                    $bagConstructorTestCase,
                ],
                $bagConstructorTestCase,
            ],
        ];
    }

    public function dotDataProvider()
    {
        return [
            [
                [
                    'foo.bar' => 'hello world',
                    'testing.dot.notation' => [
                        'works.deep' => ['123', '456', '789',],
                    ],
                ],
                [
                    'foo' => [
                        'bar' => 'hello world',
                    ],
                    'testing' => [
                        'dot' => [
                            'notation' => [
                                'works' => [
                                    'deep' => ['123', '456', '789',],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param  mixed  $bag  The value to pass to the utility
     * @param  array  $expected  The value expected to be returned
     *
     * @dataProvider dotDataProvider
     * @covers       \Myerscode\Utilities\Bags\DotUtility::__construct
     */
    public function testBagConstructsFromFlaDotNotationArray($bag, $expected)
    {
        $this->assertEquals($expected, $this->dot($bag)->value());
    }

    /**
     * Test that the constructor takes value and sets it internally
     *
     * @param  array  $expected  The value expected to be returned
     * @param  mixed  $bag  The value to pass to the utility
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
     * @param  array  $expected  The value expected to be returned
     * @param  mixed  $bag  The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::make
     */
    public function testBagIsSetViaMake($expected, $bag)
    {
        $this->assertEquals($expected, Utility::make($bag)->value());
    }

    /**
     * @param  mixed  $bag  The value to pass to the utility
     * @param  array  $expected  The value expected to be returned
     *
     * @dataProvider dotDataProvider
     * @covers       \Myerscode\Utilities\Bags\DotUtility::make
     */
    public function testBagMakesFromFlaDotNotationArray($bag, $expected)
    {
        $this->assertEquals($expected, DotUtility::make($bag)->value());
    }


}
