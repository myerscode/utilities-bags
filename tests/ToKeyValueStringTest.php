<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class ToKeyValueStringTest extends BaseBagSuite
{
    public static function __defaultGlueData(): Iterator
    {
        yield 'indexed array' => [
            [1, 2, 3],
            "0='1' 1='2' 2='3'",
        ];
        yield 'associative array' => [
            ['hello' => 'world', 'foo' => 'bar'],
            "hello='world' foo='bar'",
        ];
    }

    public function testCustomParameters(): void
    {
        $bag = ['host' => 'localhost', 'port' => '3306'];

        $this->assertSame(
            '--host="localhost" --port="3306"',
            $this->utility($bag)->toKeyValueString(' ', '--', '', '=', '"', '"')
        );
    }

    #[DataProvider('__defaultGlueData')]
    public function testDefaultGlue(array $bag, string $expected): void
    {
        $this->assertSame($expected, $this->utility($bag)->toKeyValueString());
    }
}
