<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Support\BaseBagSuite;
use Iterator;

final class MergeTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        $stdC = new stdClass();
        $stdC->hello = 'goodbye';
        yield 'empty arrays' => [
            [],
            [],
            [],
        ];
        yield 'indexed arrays' => [
            [1, 2, 3],
            [4, 5, 6],
            [1, 2, 3, 4, 5, 6],
        ];
        yield 'mixed arrays' => [
            [1, 2, 3],
            ['foo' => 'bar'],
            [1, 2, 3, 'foo' => 'bar'],
        ];
        yield 'associative arrays 1' => [
            ['index' => ['foo']],
            ['index' => ['bar']],
            ['index' => ['bar']],
        ];
        yield 'associative arrays 2' => [
            ['hello' => 'world'],
            ['hello' => 'goodbye'],
            ['hello' => 'goodbye'],
        ];
        yield 'merges bag' => [
            ['hello' => 'world'],
            new Utility(['hello' => 'goodbye']),
            ['hello' => 'goodbye'],
        ];
        yield 'merges object' => [
            ['hello' => 'world'],
            $stdC,
            ['hello' => 'goodbye'],
        ];
        yield 'merges keys and index' => [
            ['Tor', 'Fred', 'foo' => ['bar' => 'value']],
            [1 => 'Chris', 'foo' => 'hello world'],
            ['Tor', 'Fred', 'Chris', 'foo' => 'hello world'],
        ];
    }

    public static function __validDotData(): Iterator
    {
        $stdC = new stdClass();
        $stdC->hello = 'goodbye';
        yield [
            ['foo' => ['bar' => 'value']],
            ['foo.bar' => 'hello world'],
            ['foo' => ['bar' => 'hello world']],
        ];
        yield [
            ['foo.bar' => ['hello']],
            ['foo.bar.hello' => 'world'],
            ['foo' => ['bar' => ['hello' => 'world']]],
        ];
        yield [
            ['foo' => ['bar' => 'value']],
            ['foo' => 'hello world'],
            ['foo' => 'hello world'],
        ];
        yield 'merges bag' => [
            ['foobar' => ['hello' => 'world']],
            new DotUtility(['foobar.hello' => 'goodbye']),
            ['foobar' => ['hello' => 'goodbye']],
        ];
        yield 'merges object' => [
            ['hello' => 'world'],
            $stdC,
            ['hello' => 'goodbye'],
        ];
    }

    #[DataProvider('__validData')]
    public function testDotUtilityCanMergeArray(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    #[DataProvider('__validDotData')]
    public function testDotUtilityCanMergeDotArrays(array $bag, DotUtility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    #[DataProvider('__validData')]
    public function testUtilityCanMergeArray(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->utility($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }
}
