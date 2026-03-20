<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class RemoveEmptyTest extends BaseBagSuite
{
    /**
     * Test that bag knows its length
     */
    public function testBagCanRemoveEmptyValues(): void
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

        $this->assertSame($expected, $this->utility($bag)->removeEmpty()->value());

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

        $this->assertSame($expected, $this->utility($bag)->removeEmpty()->value());
    }
}
