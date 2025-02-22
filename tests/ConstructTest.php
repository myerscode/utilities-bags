<?php

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

class ConstructTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        $bagConstructorTestCase = new BagConstructorTestCase;

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
                new stdClass,
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

    public static function __validDotData(): array
    {
        return [
            [
                [
                    'foo.bar' => 'hello world',
                    'testing.dot.notation' => [
                        'works.deep' => ['123', '456', '789'],
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
                                    'deep' => ['123', '456', '789'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('__validDotData')]
    public function test_bag_constructs_from_fla_dot_notation_array(array $bag, array $expected): void
    {
        $this->assertEquals($expected, $this->dot($bag)->value());
    }

    /**
     * Test that the constructor takes value and sets it internally
     */
    #[DataProvider('__validData')]
    public function test_bag_is_set_via_constructor(array $expected, $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->value());
    }

    /**
     * Test that the static make method takes value and sets it internally
     */
    #[DataProvider('__validData')]
    public function test_bag_is_set_via_make(array $expected, $bag): void
    {
        $this->assertEquals($expected, Utility::make($bag)->value());
    }

    #[DataProvider('__validDotData')]
    public function test_bag_makes_from_fla_dot_notation_array(array $bag, array $expected): void
    {
        $this->assertEquals($expected, DotUtility::make($bag)->value());
    }

    public function test_bag_accepts_nothing_and_creates_empty_bag(): void
    {
        $this->assertEquals([], Utility::make()->value());
    }

    public function test_dot_bag_accepts_nothing_and_creates_empty_bag(): void
    {
        $this->assertEquals([], DotUtility::make()->value());
    }
}
