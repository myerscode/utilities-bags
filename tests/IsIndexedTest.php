<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class IsIndexedTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            'associative keys' => [
                false,
                ['foo' => 'bar', 'hello' => 'world'],
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
            'indexed keys 3' => [
                true,
                [1 => 'foo', 2 => 'bar', 7 => 'hello', 49 => 'world'],
            ],
            'indexed keys with a string numerical index' => [
                true,
                [0 => 'hello', '1' => 'world'],
            ],
        ];
    }

    /**
     * Test that isIndexed returns true if the bag is an indexed array
     *
     * @param  bool  $expected  The expected result
     * @param  string  $bag  The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::isIndexed
     */
    public function testBagIsIndexed($expected, $bag)
    {
        $this->assertEquals($expected, $this->utility($bag)->isIndexed());
    }
}
