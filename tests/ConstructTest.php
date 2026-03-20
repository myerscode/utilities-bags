<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;
use Iterator;

final class ConstructTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        $bagConstructorTestCase = new BagConstructorTestCase();
        yield 'array with integers' => [
            [1, 2, 3, 4, 5],
            [1, 2, 3, 4, 5],
        ];
        yield 'single integer' => [
            [1],
            1,
        ];
        yield 'array with string integers' => [
            ['1', '2', '3', '4', '5'],
            ['1', '2', '3', '4', '5'],
        ];
        yield 'single string integers' => [
            ['2'],
            '2',
        ];
        yield 'associative array' => [
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield 'json' => [
            ['1', '2', '3', '4', '5'],
            json_decode(json_encode([1, 2, 3, 4, 5]), false, 512, JSON_THROW_ON_ERROR),
        ];
        yield 'empty class' => [
            [],
            new stdClass(),
        ];
        yield 'empty array' => [
            [],
            [],
        ];
        yield 'class with toArray' => [
            [
                $bagConstructorTestCase,
            ],
            $bagConstructorTestCase,
        ];
    }

    public static function __validDotData(): Iterator
    {
        yield [
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
        ];
    }

    public function testBagAcceptsNothingAndCreatesEmptyBag(): void
    {
        $this->assertSame([], Utility::make()->value());
    }

    #[DataProvider('__validDotData')]
    public function testBagConstructsFromFlaDotNotationArray(array $bag, array $expected): void
    {
        $this->assertEquals($expected, $this->dot($bag)->value());
    }

    /**
     * Test that the constructor takes value and sets it internally
     */
    #[DataProvider('__validData')]
    public function testBagIsSetViaConstructor(array $expected, $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->value());
    }

    /**
     * Test that the static make method takes value and sets it internally
     */
    #[DataProvider('__validData')]
    public function testBagIsSetViaMake(array $expected, $bag): void
    {
        $this->assertEquals($expected, Utility::make($bag)->value());
    }

    #[DataProvider('__validDotData')]
    public function testBagMakesFromFlaDotNotationArray(array $bag, array $expected): void
    {
        $this->assertEquals($expected, DotUtility::make($bag)->value());
    }

    public function testDotBagAcceptsNothingAndCreatesEmptyBag(): void
    {
        $this->assertSame([], DotUtility::make()->value());
    }
}
