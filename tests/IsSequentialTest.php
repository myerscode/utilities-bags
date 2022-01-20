<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class IsSequentialTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            'associative keys' => [
                false,
                ['foo' => 'bar', 'hello' => 'world'],
            ],
            'mixed' => [
                false,
                ['foo', 7 => 'bar', 'hello' => 'world'],
            ],
            'empty' => [
                true,
                [],
            ],
            'indexed keys 1' => [
                true,
                [1, 2, 3, 4],
            ],
            'indexed keys 2' => [
                true,
                ['foo', 'bar', 'hello', 'world'],
            ],
            'string indexed keys unordered' => [
                true,
                ['0' => 'foo', '1' => 'bar', '3' => 'hello', '2' => 'world'],
            ],
            'string indexed keys ordered' => [
                true,
                ['0' => 'foo', '1' => 'bar', '3' => 'hello', '2' => 'world'],
            ],
            'indexed keys with a string numerical index' => [
                true,
                [0 => 'hello', '1' => 'world'],
            ],
        ];
    }

    /**
     * Test that isSequential returns true if the bag is an sequential indexed array
     *
     * @param  bool  $expected  The expected result
     * @param  string  $bag  The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::isSequential
     */
    public function testBagIsSequential($expected, $bag)
    {
        $this->assertEquals($expected, $this->utility($bag)->isSequential());
    }
}
