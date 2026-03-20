<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Support\BaseBagSuite;
use Iterator;

final class MergeRecursivelyTest extends BaseBagSuite
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
        yield 'associative arrays 1' => [
            ['index' => ['foo']],
            ['index' => ['bar']],
            ['index' => ['foo', 'bar']],
        ];
        yield 'associative arrays 2' => [
            ['hello' => 'world'],
            ['hello' => 'goodbye'],
            ['hello' => ['world', 'goodbye']],
        ];
        yield 'merges bag' => [
            ['hello' => 'world'],
            new Utility(['hello' => 'goodbye']),
            ['hello' => ['world', 'goodbye']],
        ];
        yield 'merges object' => [
            ['hello' => 'world'],
            $stdC,
            ['hello' => ['world', 'goodbye']],
        ];
        yield 'merges keys and index' => [
            ['Tor', 'Fred', 'foo' => ['bar' => 'value']],
            [1 => 'Chris', 'foo' => 'hello world'],
            ['Tor', 'Fred', 'Chris', 'foo' => ['hello world', 'bar' => 'value']],
        ];
    }

    public static function __validDotData(): Iterator
    {
        $stdC = new stdClass();
        $stdC->hello = 'goodbye';
        yield [
            ['foo' => ['bar' => 'value']],
            ['foo.bar' => 'hello world'],
            ['foo' => ['bar' => ['value', 'hello world']]],
        ];
        yield [
            ['foo.bar' => ['hello']],
            ['foo.bar.hello' => 'world'],
            ['foo' => ['bar' => ['hello', 'hello' => 'world']]],
        ];
        yield [
            ['foo' => ['bar' => 'value']],
            ['foo' => 'hello world'],
            ['foo' => ['hello world', 'bar' => 'value']],
        ];
        yield 'merges bag' => [
            ['foobar' => ['hello' => 'world']],
            new DotUtility(['foobar.hello' => 'goodbye']),
            ['foobar' => ['hello' => ['world', 'goodbye']]],
        ];
        yield 'merges object' => [
            ['hello' => 'world'],
            $stdC,
            ['hello' => ['world', 'goodbye']],
        ];
    }

    #[DataProvider('__validData')]
    public function testDotUtilityCanMergeArrayRecursively(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    #[DataProvider('__validDotData')]
    public function testDotUtilityCanMergeDotArraysRecursively(array $bag, DotUtility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    public function testDotUtilityMergeReturnsNewInstance(): void
    {
        $dotUtility = $this->dot([1, 2, 3]);
        $utility = $dotUtility->mergeRecursively([4, 5, 6]);
        $this->assertNotEquals($dotUtility, $utility);
        $this->assertInstanceOf(DotUtility::class, $utility);
    }

    #[DataProvider('__validData')]
    public function testUtilityCanMergeArrayRecursively(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->utility($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }
}
