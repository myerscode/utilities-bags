<?php

declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use Tests\Support\BaseBagSuite;

final class MapKeysTest extends BaseBagSuite
{
    public function testCanRemapKeys(): void
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

    public function testThrowsErrorIfMoreThanOneValueReturned(): void
    {
        $rawValues = [
            ['abc', 'xyz'],
            ['foo', 'bar'],
        ];

        $this->expectException(InvalidArgumentException::class);

        $this->utility($rawValues)->mapKeys(fn ($key, $value): array => [...$value])->value();
    }
}
