<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class IsAssociativeTest extends BaseBagSuite
{

    public function validDataProvider()
    {
        return [
            [
                ['foo' => 'bar', 'hello' => 'world']
            ],
            [
                ['foo' => ['hello' => 'world']]
            ],
            [
                ['foo' => ['bar', 'hello', 'world']]
            ],
            [
                [0 => 'hello', 'one' => 'world']
            ],
        ];
    }

    public function invalidDataProvider()
    {
        return [
            [
                [1, 2, 3, 4]
            ],
            [
                ['foo', 'bar', 'hello', 'world']
            ],
            [
                [0 => 'hello', '1' => 'world']
            ],
            [
                [['hello' => 'world']]
            ],
            [
                []
            ],
        ];
    }

    /**
     * Test that isAssociative returns true if the bag is an associative array
     *
     * @param string $bag The value to pass to the utility
     * @dataProvider validDataProvider
     * @covers ::isAssociative
     */
    public function testBagIsAssociativeArray($bag)
    {
        $this->assertTrue($this->utility($bag)->isAssociative());
    }

    /**
     * Test that isAssociative returns false if the bag is not an associative array
     *
     * @param string $bag The value to pass to the utility
     * @dataProvider invalidDataProvider
     * @covers ::isAssociative
     */
    public function testBagIsNotAssociativeArray($bag)
    {
        $this->assertFalse($this->utility($bag)->isAssociative());
    }

}
