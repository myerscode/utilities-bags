<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class RemoveEmptyTest extends BaseBagSuite
{

    /**
     * Test that bag knows its length
     *
     * @covers ::removeEmpty
     */
    public function testBagCanRemoveEmptyValues()
    {
        $expected = [
            'foo',
            'bar',
        ];

        $bag = [
            'foo',
            null,
            'bar',
            '',
            false,
        ];

        $this->assertEquals($expected, $this->utility($bag)->removeEmpty()->value());

        $expected = [
            'foo' => 'bar',
        ];

        $bag = [
            'foo' => 'bar',
            'hello' => '',
            'abc' => null,
            123 => false,
            null,
            '',
            0,
        ];

        $this->assertEquals($expected, $this->utility($bag)->removeEmpty()->value());
    }

}
