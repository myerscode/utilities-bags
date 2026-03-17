<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class IsSequentialTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield 'associative keys' => [
            false,
            ['foo' => 'bar', 'hello' => 'world'],
        ];
        yield 'mixed' => [
            false,
            ['foo', 7 => 'bar', 'hello' => 'world'],
        ];
        yield 'empty' => [
            true,
            [],
        ];
        yield 'indexed keys 1' => [
            true,
            [1, 2, 3, 4],
        ];
        yield 'indexed keys 2' => [
            true,
            ['foo', 'bar', 'hello', 'world'],
        ];
        yield 'string indexed keys unordered' => [
            false,
            ['0' => 'foo', '1' => 'bar', '3' => 'hello', '2' => 'world'],
        ];
        yield 'string indexed keys ordered' => [
            true,
            ['0' => 'foo', '1' => 'bar', '2' => 'hello', '3' => 'world'],
        ];
        yield 'indexed keys with a string numerical index' => [
            true,
            [0 => 'hello', '1' => 'world'],
        ];
    }

    /**
     * Test that isSequential returns true if the bag is a sequentialy indexed array
     */
    #[DataProvider('__validData')]
    public function test_bag_is_sequential(bool $expected, array $bag): void
    {
        $this->assertSame($expected, $this->utility($bag)->isSequential());
    }
}
