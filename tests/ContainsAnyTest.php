<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ContainsAnyTest extends BaseBagSuite
{

    public function trueDataProvider()
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
                json_decode(json_encode([1, 2, 3]), false),
            ],
        ];
    }

    public function falseDataProvider()
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
                json_decode(json_encode([1, 2, 3]), false),
            ],
        ];
    }

    /**
     * Check true is returned when any values in needles are found in the bag
     *
     * @param string $needles Expected values
     * @param string $bag Bags values
     * @dataProvider trueDataProvider
     * @covers ::containsAny
     */
    public function testReturnsTrueIfSomeValuesArePresent($needles, $bag)
    {
        $this->assertTrue($this->utility($bag)->containsAny($needles));
        $this->assertTrue($this->utility($bag)->contains($needles));
    }

    /**
     * Check false is returned when none of the values in needles are not found in the bag
     *
     * @param string $needles Expected values
     * @param string $bag Bags values
     * @dataProvider falseDataProvider
     * @covers ::containsAny
     */
    public function testReturnsFalseIfNoValuesArePresent($needles, $bag)
    {
        $this->assertFalse($this->utility($bag)->containsAny($needles));
        $this->assertFalse($this->utility($bag)->contains($needles));
    }
}
