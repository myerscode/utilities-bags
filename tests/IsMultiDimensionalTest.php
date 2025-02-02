<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;

class IsMultiDimensionalTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        return [
            [
                false,
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
                ['foo' => ['bar', 'hello', 'world'], 'hello' => ['world' => ['foo' => 'bar']]],
            ],
            [
                true,
                [['hello' => 'world']],
            ],
            [
                true,
                [123 => ['hello' => 'world']],
            ],
            [
                false,
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
                [],
            ],
        ];
    }

    /**
     * Test that isMultiDimensional returns true if the bag is contains multidimensional data
     */
    #[DataProvider('__validData')]
    public function testBagIsMultiDimensional(bool $expected, array $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->isMultiDimensional());
    }
}
