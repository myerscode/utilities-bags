<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class GetTest extends BaseBagSuite
{
    public static function __dotGetData(): Iterator
    {
        yield 'nested values' => [
            ['hello', 'world'],
            ['deep' => ['nested' => ['values' => ['hello', 'world']]]],
            'deep.nested.values',
        ];
        yield 'dot key takes priority' => [
            'lives here',
            ['key' => ['with' => ['dot' => 'value']], 'key.with.dot' => 'lives here'],
            'key.with.dot',
        ];
        yield 'missing nested returns null' => [
            null,
            ['deep' => ['nested' => ['values' => ['hello', 'world']]]],
            'deep.nested.values.contains',
        ];
        yield 'top level key' => [
            ['nested' => ['values' => ['hello', 'world']]],
            ['deep' => ['nested' => ['values' => ['hello', 'world']]]],
            'deep',
        ];
        yield 'missing with default' => [
            'default-value',
            ['deep' => ['nested' => ['values' => ['hello', 'world']]]],
            'deep.nested.values.contains',
            'default-value',
        ];
    }

    public static function __utilityGetData(): Iterator
    {
        yield 'missing index returns null' => [
            null,
            [],
            100,
        ];
        yield 'out of bounds returns null' => [
            null,
            ['foo', 'bar'],
            2,
        ];
        yield 'first element' => [
            'foo',
            ['foo', 'bar'],
            0,
        ];
        yield 'associative key' => [
            'world',
            ['foo' => 'bar', 'hello' => 'world'],
            'hello',
        ];
        yield 'missing with default' => [
            'whoops',
            ['foo', 'bar'],
            2,
            'whoops',
        ];
        yield 'dot notation on utility returns nested' => [
            ['hello', 'world'],
            ['deep' => ['nested' => ['values' => ['hello', 'world']]]],
            'deep.nested.values',
        ];
        yield 'dot notation missing returns default' => [
            'fallback',
            ['deep' => ['nested' => 'value']],
            'deep.nested.missing',
            'fallback',
        ];
        yield 'literal dot key falls back via dotGet' => [
            'fallback',
            ['a.b' => 'value'],
            'a.b',
            'fallback',
        ];
    }

    #[DataProvider('__dotGetData')]
    public function testDotValueRetrievedFromGet(mixed $expected, array $bag, string $index, mixed $default = null): void
    {
        $this->assertEquals($expected, $this->dot($bag)->get($index, $default));
    }

    #[DataProvider('__utilityGetData')]
    public function testValueRetrievedFromGet(mixed $expected, array $bag, int|string $index, mixed $default = null): void
    {
        $this->assertEquals($expected, $this->utility($bag)->get($index, $default));
    }

    public function testValueRetrievedFromOffsetGet(): void
    {
        $this->assertEquals(null, $this->utility([])->offsetGet(100));
        $this->assertEquals(null, $this->utility(['foo', 'bar'])->offsetGet(2));
        $this->assertEquals('foo', $this->utility(['foo', 'bar'])->offsetGet(0));
        $this->assertEquals('world', $this->utility(['foo' => 'bar', 'hello' => 'world'])->offsetGet('hello'));
    }
}
