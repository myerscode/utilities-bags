<?php

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;

class IsSequentialTest extends BaseBagSuite
{
    public static function __validData(): array
    {
        return [
            'associative keys' => [
                false,
                ['foo' => 'bar', 'hello' => 'world'],
            ],
            'mixed' => [
                false,
                ['foo', 7 => 'bar', 'hello' => 'world'],
            ],
            'empty' => [
                true,
                [],
            ],
            'indexed keys 1' => [
                true,
                [1, 2, 3, 4],
            ],
            'indexed keys 2' => [
                true,
                ['foo', 'bar', 'hello', 'world'],
            ],
            'string indexed keys unordered' => [
                false,
                ['0' => 'foo', '1' => 'bar', '3' => 'hello', '2' => 'world'],
            ],
            'string indexed keys ordered' => [
                true,
                ['0' => 'foo', '1' => 'bar', '2' => 'hello', '3' => 'world'],
            ],
            'indexed keys with a string numerical index' => [
                true,
                [0 => 'hello', '1' => 'world'],
            ],
        ];
    }

    /**
     * Test that isSequential returns true if the bag is a sequentialy indexed array
     */
    #[DataProvider('__validData')]
    public function test_bag_is_sequential(bool $expected, array $bag): void
    {
        $this->assertEquals($expected, $this->utility($bag)->isSequential());
    }
}
