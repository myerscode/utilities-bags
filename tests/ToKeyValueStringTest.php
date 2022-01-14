<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ToKeyValueStringTest extends BaseBagSuite
{
    public function validDataProvider(): array
    {
        return [
            [
                [1, 2, 3],
                '0=\'1\' 1=\'2\' 2=\'3\'',
            ],
            [
                ['hello' => 'world', 'foo' => 'bar'],
                'hello=\'world\' foo=\'bar\'',
            ],
        ];
    }

    /**
     * Check that arrays correct glue with default values
     *
     * @dataProvider validDataProvider
     */
    public function testValidValueSetViaConstructor($bag, $glued)
    {
        $this->assertEquals($glued, $this->utility($bag)->toKeyValueString());
    }
}
