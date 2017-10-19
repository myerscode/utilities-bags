<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class IsAssociativeTest extends BaseBagSuite
{

    public function dataProvider()
    {
        return [
            [
                true,
                ['foo' => 'bar', 'hello' => 'world']
            ],
            [
                true,
                ['foo' => ['hello' => 'world']]
            ],
            [
                true,
                ['foo' => ['bar', 'hello', 'world']]
            ],
            [
                true,
                [0 => 'hello', 'one' => 'world']
            ],
            [
                false,
                [1, 2, 3, 4]
            ],
            [
                false,
                ['foo', 'bar', 'hello', 'world']
            ],
            [
                false,
                [0 => 'hello', '1' => 'world']
            ],
            [
                false,
                [['hello' => 'world']]
            ],
            [
                false,
                []
            ],
        ];
    }

    /**
     * Test that isAssociative returns true if the bag is an associative array
     *
     * @param bool $expected The expected result
     * @param string $bag The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::isAssociative
     */
    public function testBagIsAssociative($expected, $bag)
    {
        $this->assertEquals($expected, $this->utility($bag)->isAssociative());
    }

    /**
     * Test internal call to isAssociativeArray returns true if the bag is an associative array
     *
     * @param bool $expected The expected result
     * @param string $bag The value to pass to the utility
     *
     * @dataProvider dataProvider
     * @covers ::isAssociativeArray
     */
    public function testBagIsAssociativeArray($expected, $bag)
    {
        $class = $this->utility([]);
        $reflection = new \ReflectionClass(get_class($class));
        $method = $reflection->getMethod('isAssociativeArray');
        $method->setAccessible(true);
        $this->assertEquals($expected, $method->invokeArgs($class, [$bag]));
    }

}
