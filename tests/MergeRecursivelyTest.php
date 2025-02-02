<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Myerscode\Utilities\Bags\Utility;
use Myerscode\Utilities\Bags\DotUtility;
use stdClass;
use Tests\Support\BaseBagSuite;

class MergeRecursivelyTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        $stdC = new stdClass();
        $stdC->hello = 'goodbye';

        return [
            'empty arrays' => [
                [],
                [],
                [],
            ],
            'indexed arrays' => [
                [1, 2, 3],
                [4, 5, 6],
                [1, 2, 3, 4, 5, 6],
            ],
            'associative arrays 1' => [
                ['index' => ['foo']],
                ['index' => ['bar']],
                ['index' => ['foo', 'bar']],
            ],
            'associative arrays 2' => [
                ['hello' => 'world'],
                ['hello' => 'goodbye'],
                ['hello' => ['world', 'goodbye']],
            ],
            'merges bag' => [
                ['hello' => 'world'],
                new Utility(['hello' => 'goodbye']),
                ['hello' => ['world', 'goodbye']],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => ['world', 'goodbye']],
            ],
            'merges keys and index' => [
                ['Tor', 'Fred', 'foo' => ['bar' => 'value']],
                [1 => 'Chris', 'foo' => 'hello world'],
                ['Tor', 'Fred', 'Chris', 'foo' => ['hello world', 'bar' => 'value']],
            ],
        ];
    }

    public static function __validDotData(): array
    {
        $stdC = new stdClass();
        $stdC->hello = 'goodbye';

        return [
            [
                ['foo' => ['bar' => 'value']],
                ['foo.bar' => 'hello world'],
                ['foo' => ['bar' => ['value', 'hello world']]],
            ],
            [
                ['foo.bar' => ['hello']],
                ['foo.bar.hello' => 'world'],
                ['foo' => ['bar' => ['hello', 'hello' => 'world']]],
            ],
            [
                ['foo' => ['bar' => 'value']],
                ['foo' => 'hello world'],
                ['foo' => ['hello world', 'bar' => 'value']],
            ],
            'merges bag' => [
                ['foobar' => ['hello' => 'world']],
                new DotUtility(['foobar.hello' => 'goodbye']),
                ['foobar' => ['hello' => ['world', 'goodbye']]],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => ['world', 'goodbye']],
            ],
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
        $bagOne = $this->dot([1, 2, 3]);
        $bagTwo = $bagOne->mergeRecursively([4, 5, 6]);
        $this->assertNotEquals($bagOne, $bagTwo);
        $this->assertInstanceOf(DotUtility::class, $bagTwo);
    }

    #[DataProvider('__validData')]
    public function testUtilityCanMergeArrayRecursively(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->utility($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }
}
