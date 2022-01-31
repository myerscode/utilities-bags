<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class IteratorTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            [
                [1, 2, 3, 4, 5],
            ],
            [
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
        ];
    }

    /**
     * Test that bag can be iterated over
     *
     * @param  mixed  $bag  The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::getIterator
     */
    public function testBagIsCanBeIteratedOver($bag)
    {
        foreach ($this->utility($bag) as $index => $utility) {
            $this->assertArrayHasKey($index, $bag);
            $this->assertEquals(array_search($utility, $bag), $index);
            $this->assertEquals($bag[$index], $utility);
        }
    }

}
