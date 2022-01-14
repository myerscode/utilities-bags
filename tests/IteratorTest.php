<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class IteratorTest extends BaseBagSuite
{
    public function dataProvider(): array
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
     * @dataProvider dataProvider
     */
    public function testBagIsCanBeIteratedOver($bag)
    {
        foreach ($this->utility($bag) as $index => $item) {
            $this->assertArrayHasKey($index, $bag);
            $this->assertEquals(array_search($item, $bag), $index);
            $this->assertEquals($bag[$index], $item);
        }
    }
}
