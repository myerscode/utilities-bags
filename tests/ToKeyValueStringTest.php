<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class ToKeyValueStringTest extends BaseBagSuite
{

    public function validDataProvider()
    {
        return [
            [
                [1, 2, 3],
                '0=\'1\' 1=\'2\' 2=\'3\'',
            ],
            [
                ['hello' =>'world', 'foo' => 'bar'],
                'hello=\'world\' foo=\'bar\'',
            ],
        ];
    }

    /**
     * Check that arrays correct glue with default values
     *
     * @param string $bag Bag values
     * @param string $glued Glued bag string
     * @dataProvider validDataProvider
     * @covers ::toKeyValueString
     */
    public function testValidValueSetViaConstructor($bag, $glued)
    {
        $this->assertEquals($glued, $this->utility($bag)->toKeyValueString());
    }
}
