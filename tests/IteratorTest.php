<?php

declare(strict_types=1);

namespace Tests;

use IteratorAggregate;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class IteratorTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield [
            [1, 2, 3, 4, 5],
        ];
        yield [
            ['1', '2', '3', '4', '5'],
        ];
        yield [
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
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
