<?php

namespace Tests;

use IteratorAggregate;
use Tests\Support\BaseBagSuite;

class IteratorTest extends BaseBagSuite
{
    public function __validData(): array
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
     * @dataProvider __validData
     *
     * @param  int[]|string[]|array<string, string>  $bag
     */
    public function testBagIsCanBeIteratedOver(array $bag): void
    {
        foreach ($this->utility($bag) as $index => $utility) {
            $this->assertArrayHasKey($index, $bag);
            $this->assertEquals(array_search($utility, $bag), $index);
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
