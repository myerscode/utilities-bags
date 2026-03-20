<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class JoinTest extends BaseBagSuite
{
    public static function __joinData(): Iterator
    {
        yield 'indexed with comma' => [
            '1, 2, 3, 4, 5, 6, 7, 8, 9, 0',
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
            ', ',
            null,
        ];
        yield 'indexed with last glue' => [
            '1, 2, 3, 4, 5, 6, 7, 8, 9 and 0',
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
            ', ',
            ' and ',
        ];
        yield 'associative with comma' => [
            'Fred, Gerald, Rupert',
            ['owner' => 'Fred', 'corgi_one' => 'Gerald', 'corgi_two' => 'Rupert'],
            ', ',
            null,
        ];
        yield 'associative with last glue' => [
            'Fred, Gerald and Rupert',
            ['owner' => 'Fred', 'corgi_one' => 'Gerald', 'corgi_two' => 'Rupert'],
            ', ',
            ' and ',
        ];
        yield 'single element no last glue' => [
            'only',
            ['only'],
            ', ',
            null,
        ];
        yield 'two elements with last glue' => [
            'hello and world',
            ['hello', 'world'],
            ', ',
            ' and ',
        ];
    }

    #[DataProvider('__joinData')]
    public function test_bag_is_joined(string $expected, array $bag, string $glue, ?string $lastGlue): void
    {
        $this->assertSame($expected, $this->utility($bag)->join($glue, $lastGlue));
    }
}
