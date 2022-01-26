<?php

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use stdClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

class ConstructTest extends BaseBagSuite
{
    public function __validData(): array
    {
        $bagConstructorTestCase = new BagConstructorTestCase();

        return [
            'array with integers' => [
                [1, 2, 3, 4, 5],
                [1, 2, 3, 4, 5],
            ],
            'single integer' => [
                [1],
                1,
            ],
            'array with string integers' => [
                ['1', '2', '3', '4', '5'],
                ['1', '2', '3', '4', '5'],
            ],
            'single string integers' => [
                ['2'],
                '2',
            ],
            'associative array' => [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            'json' => [
                ['1', '2', '3', '4', '5'],
                json_decode(json_encode([1, 2, 3, 4, 5]), false, 512, JSON_THROW_ON_ERROR),
            ],
            'empty class' => [
                [],
                new stdClass(),
            ],
            'empty array' => [
                [],
                [],
            ],
            'class with toArray' => [
                [
                    $bagConstructorTestCase,
                ],
                $bagConstructorTestCase,
            ],
        ];
    }

    public function __validDotData(): array
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
     * @dataProvider __validDotData
     */
    public function testBagConstructsFromFlaDotNotationArray($bag, $expected): void
    {
        $this->assertEquals($expected, $this->dot($bag)->value());
    }

    /**
     * Test that the constructor takes value and sets it internally
     *
     * @dataProvider __validData
     */
    public function testBagIsSetViaConstructor($expected, $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->value());
    }

    /**
     * Test that the static make method takes value and sets it internally
     *
     * @dataProvider  __validData
     */
    public function testBagIsSetViaMake($expected, $bag): void
    {
        $this->assertEquals($expected, Utility::make($bag)->value());
    }

    /**
     * @dataProvider __validDotData
     */
    public function testBagMakesFromFlaDotNotationArray($bag, $expected): void
    {
        $this->assertEquals($expected, DotUtility::make($bag)->value());
    }
}
