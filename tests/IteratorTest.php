<?php

namespace Tests;

use IteratorAggregate;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;

class IteratorTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        return [
            [
                [1, 2, 3, 4, 5],
            ],
            [
                ['1', '2', '3', '4', '5'],
            ],
            [
                ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
            ],
        ];
    }

    /**
     * Test that bag can be iterated over
     *
     *
     * @param  int[]|string[]|array<string, string>  $bag
     */
    #[DataProvider('__validData')]
    public function test_bag_is_can_be_iterated_over(array $bag): void
    {
        foreach ($this->utility($bag) as $index => $utility) {
            $this->assertArrayHasKey($index, $bag);
            $this->assertEquals(array_search($utility, $bag, true), $index);
            $this->assertEquals($bag[$index], $utility);
        }
    }

    /**
     * Test that bag can be iterated over
     */
    public function test_implements_iterator_aggregate(): void
    {
        $this->assertInstanceOf(IteratorAggregate::class, $this->utility([]));
    }
}
