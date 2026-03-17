<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use Tests\Support\BaseBagSuite;

final class MapKeysTest extends BaseBagSuite
{
    public function test_can_remap_keys(): void
    {
        $rawValues = [
            ['abc', 'xyz'],
            ['foo', 'bar'],
        ];

        $expectedValues = [
            'abc' => 'xyz',
            'foo' => 'bar',
        ];

        $mapped = $this->utility($rawValues)->mapKeys(fn ($key, $value): array => [$value[0] => $value[1]])->value();

        $this->assertSame($expectedValues, $mapped);
    }

    public function test_throws_error_if_more_than_one_value_returned(): void
    {
        $rawValues = [
            ['abc', 'xyz'],
            ['foo', 'bar'],
        ];

        $this->expectException(InvalidArgumentException::class);

        $this->utility($rawValues)->mapKeys(fn ($key, $value): array => [...$value])->value();
    }
}
