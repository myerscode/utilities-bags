<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class IsAssociativeTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield [
            true,
            ['foo' => 'bar', 'hello' => 'world'],
        ];
        yield [
            true,
            ['foo' => ['hello' => 'world']],
        ];
        yield [
            true,
            ['foo' => ['bar', 'hello', 'world']],
        ];
        yield [
            true,
            [0 => 'hello', 'one' => 'world'],
        ];
        yield [
            false,
            [1, 2, 3, 4],
        ];
        yield [
            false,
            ['foo', 'bar', 'hello', 'world'],
        ];
        yield [
            false,
            [0 => 'hello', '1' => 'world'],
        ];
        yield [
            false,
            [['hello' => 'world']],
        ];
        yield [
            false,
            [],
        ];
    }

    /**
     * Test that isAssociative returns true if the bag is an associative array
     */
    #[DataProvider('__validData')]
    public function testBagIsAssociative(bool $expected, array $bag): void
    {
        $this->assertSame($expected, $this->utility($bag)->isAssociative());
    }
}
