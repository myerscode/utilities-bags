<?php

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Tests\Support\BaseBagSuite;

class MergeRecursivelyTest extends BaseBagSuite
{

    public function dataProvider()
    {
        $stdC = new \stdClass();
        $stdC->hello = 'goodbye';

        return [
            'empty arrays' => [
                [],
                [],
                [],
            ],
            'indexed arrays' => [
                [1,2,3],
                [4,5,6],
                [1,2,3,4,5,6],
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
                $this->utility(['hello' => 'goodbye']),
                ['hello' => ['world', 'goodbye']],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => ['world', 'goodbye']],
            ],
        ];
    }

    public function dotDataProvider()
    {
        $stdC = new \stdClass();
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
                $this->dot(['foobar.hello' => 'goodbye']),
                ['foobar' => ['hello' => ['world', 'goodbye']]],
            ],
            'merges object' => [
                ['hello' => 'world'],
                $stdC,
                ['hello' => ['world', 'goodbye']],
            ],
        ];
    }

    /**
     * Test that merge creates expected outcome
     *
     * @dataProvider dataProvider
     * @covers \Myerscode\Utilities\Bags\Utility::mergeRecursively
     */
    public function testUtilityCanMergeArrayRecursively($bag, $merge, $expected)
    {
        $bag = $this->utility($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    /**
     * Test that merge creates expected outcome
     *
     * @dataProvider dataProvider
     * @covers \Myerscode\Utilities\Bags\DotUtility::mergeRecursively
     */
    public function testDotUtilityCanMergeArrayRecursively($bag, $merge, $expected)
    {
        $bag = $this->dot($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    /**
     * Test that merge creates expected outcome
     *
     * @dataProvider dotDataProvider
     * @covers \Myerscode\Utilities\Bags\DotUtility::mergeRecursively
     */
    public function testDotUtilityCanMergeDotArraysRecursively($bag, $merge, $expected)
    {
        $bag = $this->dot($bag)->mergeRecursively($merge)->value();
        $this->assertEquals($expected, $bag);
    }

    public function testDotUtilityMergeReturnsNewInstance()
    {
        $bagOne = $this->dot([1, 2, 3]);
        $bagTwo = $bagOne->mergeRecursively([4, 5, 6]);
        $this->assertNotEquals($bagOne, $bagTwo);
        $this->assertInstanceOf(DotUtility::class, $bagTwo);
    }
}
