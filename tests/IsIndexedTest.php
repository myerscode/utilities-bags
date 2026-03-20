<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class IsIndexedTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield 'associative keys' => [
            false,
            ['foo' => 'bar', 'hello' => 'world'],
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
        yield 'indexed keys 3' => [
            true,
            [1 => 'foo', 2 => 'bar', 7 => 'hello', 49 => 'world'],
        ];
        yield 'indexed keys with a string numerical index' => [
            true,
            [0 => 'hello', '1' => 'world'],
        ];
    }

    /**
     * Test that isIndexed returns true if the bag is an indexed array
     */
    #[DataProvider('__validData')]
    public function testBagIsIndexed(bool $expected, array $bag): void
    {
        $this->assertSame($expected, $this->utility($bag)->isIndexed());
    }
}
