<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class MapTest extends BaseBagSuite
{
    public function testCanMapValues(): void
    {
        $rawValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $expectedValues = [7, 14, 21, 28, 35, 42, 49, 56, 63, 70];

        $mapped = $this->utility($rawValues)->map(fn($value): int|float => $value * 7)->value();

        $this->assertEquals($expectedValues, $mapped);
    }
}
