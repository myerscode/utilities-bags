<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class IsMultiDimensionalTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield [
            false,
            ['foo' => 'bar', 'hello' => 'world'],
        ];
        yield [
            true,
            ['foo' => ['hello' => 'world']],
        ];
        yield [
            true,
            ['foo' => ['bar', 'hello', 'world']],
        ];
        yield [
            true,
            ['foo' => ['bar', 'hello', 'world'], 'hello' => ['world' => ['foo' => 'bar']]],
        ];
        yield [
            true,
            [['hello' => 'world']],
        ];
        yield [
            true,
            [123 => ['hello' => 'world']],
        ];
        yield [
            false,
            [0 => 'hello', 'one' => 'world'],
        ];
        yield [
            false,
            [1, 2, 3, 4],
        ];
        yield [
            false,
            ['foo', 'bar', 'hello', 'world'],
        ];
        yield [
            false,
            [0 => 'hello', '1' => 'world'],
        ];
        yield [
            false,
            [],
        ];
    }

    /**
     * Test that isMultiDimensional returns true if the bag is contains multidimensional data
     */
    #[DataProvider('__validData')]
    public function test_bag_is_multi_dimensional(bool $expected, array $bag): void
    {
        $this->assertSame($expected, $this->utility($bag)->isMultiDimensional());
    }
}
