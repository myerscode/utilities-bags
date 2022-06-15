<?php

namespace Tests;

use Myerscode\Utilities\Bags\Exceptions\InvalidMappedValueException;
use Tests\Support\BaseBagSuite;

class MapKeysTest extends BaseBagSuite
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

        $mapped = $this->utility($rawValues)->mapKeys(fn($key, $value) => [$value[0] => $value[1]])->value();

        $this->assertEquals($expectedValues, $mapped);
    }

    public function testThrowsErrorIfMoreThanOneValueReturned(): void
    {
        $rawValues = [
            ['abc', 'xyz'],
            ['foo', 'bar'],
        ];

        $this->expectException(InvalidMappedValueException::class);

        $this->utility($rawValues)->mapKeys(fn($key, $value) => [...$value])->value();
    }
}
