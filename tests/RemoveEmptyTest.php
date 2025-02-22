<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class RemoveEmptyTest extends BaseBagSuite
{
    /**
     * Test that bag knows its length
     */
    public function test_bag_can_remove_empty_values(): void
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
