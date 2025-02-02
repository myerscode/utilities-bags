<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use IteratorAggregate;
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
    public function testBagIsCanBeIteratedOver(array $bag): void
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
    public function testImplementsIteratorAggregate(): void
    {
        $this->assertInstanceOf(IteratorAggregate::class, $this->utility([]));
    }
}
