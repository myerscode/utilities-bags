<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class ToKeyValueStringTest extends BaseBagSuite
{
    public static function validDataProvider(): Iterator
    {
        yield [
            [1, 2, 3],
            "0='1' 1='2' 2='3'",
        ];
        yield [
            ['hello' => 'world', 'foo' => 'bar'],
            "hello='world' foo='bar'",
        ];
    }

    /**
     * Check that arrays correct glue with default values
     */
    #[DataProvider('validDataProvider')]
    public function test_valid_value_set_via_constructor(array $bag, string $glued): void
    {
        $this->assertSame($glued, $this->utility($bag)->toKeyValueString());
    }
}
