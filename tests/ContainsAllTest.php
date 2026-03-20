<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class ContainsAllTest extends BaseBagSuite
{
    public static function __invalidData(): Iterator
    {
        yield [
            [3, 6, 9],
            [1, 2, 3, 4, 5],
        ];
        yield [
            9,
            [1, 2, 3, 4, 5],
        ];
        yield [
            ['3', '6', '9'],
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            '6',
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            ['foo' => 'bar', 'fox' => '', 'quick'],
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            'bar',
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            ['1', '5', '9'],
            json_decode(json_encode([1, 3, 5]), false, 512, JSON_THROW_ON_ERROR),
        ];
    }

    public static function __validData(): Iterator
    {
        yield [
            [1, 2, 3],
            [1, 2, 3, 4, 5],
        ];
        yield [
            1,
            [1, 2, 3, 4, 5],
        ];
        yield [
            ['1', '2', '3'],
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            '2',
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            ['hello' => 'world', 'fox' => ''],
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            'world',
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            '',
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            ['1', '5'],
            json_decode(json_encode([1, 3, 5]), false, 512, JSON_THROW_ON_ERROR),
        ];
    }

    /**
     * Check false is returned when all values in needles are not found in the bag
     */
    #[DataProvider('__invalidData')]
    public function testReturnsFalseIfSomeValuesAreMissing(int|string|array $needles, $bag): void
    {
        $this->assertFalse($this->utility($bag)->containsAll($needles));
    }

    /**
     * Check true is returned when all values in needles are found in the bag
     */
    #[DataProvider('__validData')]
    public function testReturnsTrueIfSomeValuesArePresent(int|string|array $needles, $bag): void
    {
        $this->assertTrue($this->utility($bag)->containsAll($needles));
    }
}
