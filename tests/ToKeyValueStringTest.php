<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;

class ToKeyValueStringTest extends BaseBagSuite
{
    /**
     * Check that arrays correct glue with default values
     */
    #[DataProvider('validDataProvider')]
    public function test_valid_value_set_via_constructor(array $bag, string $glued): void
    {
        $this->assertEquals($glued, $this->utility($bag)->toKeyValueString());
    }

    public static function validDataProvider(): array
    {
        return [
            [
                [1, 2, 3],
                "0='1' 1='2' 2='3'",
            ],
            [
                ['hello' => 'world', 'foo' => 'bar'],
                "hello='world' foo='bar'",
            ],
        ];
    }
}
