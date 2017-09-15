<?php

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class IteratorTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            [
                [1, 2, 3, 4, 5]
            ],
            [
                ['1', '2', '3', '4', '5']
            ],
            [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => '']
            ],
        ];
    }

    /**
     * Test that bag can be iterated over
     *
     * @param mixed $bag The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::getIterator
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
