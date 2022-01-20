<?php

namespace Tests;

use stdClass;
use Tests\Support\BaseBagSuite;

class MergeTest extends BaseBagSuite
{
    public function __validData(): array
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
                $this->utility(['hello' => 'goodbye']),
                ['hello' => 'goodbye'],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => 'goodbye'],
            ],
        ];
    }

    public function __validDotData(): array
    {
        $stdC = new stdClass();
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
                $this->dot(['foobar.hello' => 'goodbye']),
                ['foobar' => ['hello' => 'goodbye']],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => 'goodbye'],
            ],
        ];
    }

    /**
     * @dataProvider __validData
     */
    public function testDotUtilityCanMergeArray($bag, $merge, $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    /**
     * @dataProvider __validDotData
     */
    public function testDotUtilityCanMergeDotArrays($bag, $merge, $expected): void
    {
        $bag = $this->dot($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    /**
     * @dataProvider __validData
     */
    public function testUtilityCanMergeArray($bag, $merge, $expected): void
    {
        $bag = $this->utility($bag)->merge($merge)->value();
        $this->assertEquals($expected, $bag);
    }
}
