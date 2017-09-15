<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ContainsAllTest extends BaseBagSuite
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
                json_decode(json_encode([1, 3, 5]), false),
            ],
        ];
    }

    public function falseDataProvider()
    {
        return [
            [
                [3, 6, 9],
                [1, 2, 3, 4, 5],
            ],
            [
                ['3', '6', '9'],
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['foo' => 'bar', 'fox' => '', 'quick'],
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
            [
                ['1', '5', '9'],
                json_decode(json_encode([1, 3, 5]), false),
            ],
        ];
    }

    /**
     * Check true is returned when all values in needles are found in the bag
     *
     * @param string $needles Values to check for
     * @param string $bag The bags values
     *
     * @dataProvider trueDataProvider
     * @covers ::containsAll
     */
    public function testReturnsTrueIfSomeValuesArePresent($needles, $bag)
    {
        $this->assertTrue($this->utility($bag)->containsAll($needles));
    }

    /**
     * Check false is returned when all values in needles are not found in the bag
     *
     * @param string $needles Values to check for
     * @param string $bag The bags values
     *
     * @dataProvider falseDataProvider
     * @covers ::containsAll
     */
    public function testReturnsFalseIfSomeValuesAreMissing($needles, $bag)
    {
        $this->assertFalse($this->utility($bag)->containsAll($needles));
    }
}
