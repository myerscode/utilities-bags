<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ContainsAnyTest extends BaseBagSuite
{
    public static function __invalidData(): array
    {
        return [
            [
                [9, 10, 11],
                [1, 2, 3, 4, 5],
            ],
            [
                ['9', '10', '11'],
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['foo' => 'bar'],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            [
                ['9', '10', '11'],
                json_decode(json_encode([1, 2, 3]), false, 512, JSON_THROW_ON_ERROR),
            ],
        ];
    }

    public static function __validData(): array
    {
        return [
            [
                [1, 2, 3],
                [1, 2, 3, 4, 5],
            ],
            [
                ['1', '2', '3'],
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['hello' => 'world', 'fox' => ''],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            [
                ['1', '5'],
                json_decode(json_encode([1, 2, 3]), false, 512, JSON_THROW_ON_ERROR),
            ],
        ];
    }

    /**
     * Check false is returned when none of the values in needles are not found in the bag
     *
     * @dataProvider __invalidData
     */
    public function testReturnsFalseIfNoValuesArePresent(array $needles, $bag): void
    {
        $this->assertFalse($this->utility($bag)->containsAny($needles));
        $this->assertFalse($this->utility($bag)->contains($needles));
    }

    /**
     * @dataProvider __validData
     */
    public function testReturnsTrueIfSomeValuesArePresent(array $needles, $bag): void
    {
        $this->assertTrue($this->utility($bag)->containsAny($needles));
        $this->assertTrue($this->utility($bag)->contains($needles));
    }
}
