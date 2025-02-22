<?php

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Support\BaseBagSuite;

class MergeTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        $stdC = new stdClass;
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
            'mixed arrays' => [
                [1, 2, 3],
                ['foo' => 'bar'],
                [1, 2, 3, 'foo' => 'bar'],
            ],
            'associative arrays 1' => [
                ['index' => ['foo']],
                ['index' => ['bar']],
                ['index' => ['bar']],
            ],
            'associative arrays 2' => [
                ['hello' => 'world'],
                ['hello' => 'goodbye'],
                ['hello' => 'goodbye'],
            ],
            'merges bag' => [
                ['hello' => 'world'],
                new Utility(['hello' => 'goodbye']),
                ['hello' => 'goodbye'],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => 'goodbye'],
            ],
            'merges keys and index' => [
                ['Tor', 'Fred', 'foo' => ['bar' => 'value']],
                [1 => 'Chris', 'foo' => 'hello world'],
                ['Tor', 'Fred', 'Chris', 'foo' => 'hello world'],
            ],
        ];
    }

    public static function __validDotData(): array
    {
        $stdC = new stdClass;
        $stdC->hello = 'goodbye';

        return [
            [
                ['foo' => ['bar' => 'value']],
                ['foo.bar' => 'hello world'],
                ['foo' => ['bar' => 'hello world']],
            ],
            [
                ['foo.bar' => ['hello']],
                ['foo.bar.hello' => 'world'],
                ['foo' => ['bar' => ['hello' => 'world']]],
            ],
            [
                ['foo' => ['bar' => 'value']],
                ['foo' => 'hello world'],
                ['foo' => 'hello world'],
            ],
            'merges bag' => [
                ['foobar' => ['hello' => 'world']],
                new DotUtility(['foobar.hello' => 'goodbye']),
                ['foobar' => ['hello' => 'goodbye']],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => 'goodbye'],
            ],
        ];
    }

    #[DataProvider('__validData')]
    public function test_dot_utility_can_merge_array(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    #[DataProvider('__validDotData')]
    public function test_dot_utility_can_merge_dot_arrays(array $bag, DotUtility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    #[DataProvider('__validData')]
    public function test_utility_can_merge_array(array $bag, Utility|stdClass|array $merge, array $expected): void
    {
        $bag = $this->utility($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }
}
