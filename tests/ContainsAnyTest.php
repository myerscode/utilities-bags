<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class ContainsAnyTest extends BaseBagSuite
{
    public static function __invalidData(): Iterator
    {
        yield [
            [9, 10, 11],
            [1, 2, 3, 4, 5],
        ];
        yield [
            ['9', '10', '11'],
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            ['foo' => 'bar'],
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            ['9', '10', '11'],
            json_decode(json_encode([1, 2, 3]), false, 512, JSON_THROW_ON_ERROR),
        ];
    }

    public static function __validData(): Iterator
    {
        yield [
            [1, 2, 3],
            [1, 2, 3, 4, 5],
        ];
        yield [
            ['1', '2', '3'],
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            ['hello' => 'world', 'fox' => ''],
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            ['1', '5'],
            json_decode(json_encode([1, 2, 3]), false, 512, JSON_THROW_ON_ERROR),
        ];
    }

    /**
     * Check false is returned when none of the values in needles are not found in the bag
     */
    #[DataProvider('__invalidData')]
    public function test_returns_false_if_no_values_are_present(array $needles, $bag): void
    {
        $this->assertFalse($this->utility($bag)->containsAny($needles));
        $this->assertFalse($this->utility($bag)->contains($needles));
    }

    #[DataProvider('__validData')]
    public function test_returns_true_if_some_values_are_present(array $needles, $bag): void
    {
        $this->assertTrue($this->utility($bag)->containsAny($needles));
        $this->assertTrue($this->utility($bag)->contains($needles));
    }
}
