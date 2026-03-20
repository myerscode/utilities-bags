<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;
use Iterator;

final class CountTest extends BaseBagSuite
{
    public static function __validData(): Iterator
    {
        yield [
            0,
            [],
        ];
        yield [
            5,
            [1, 2, 3, 4, 5],
        ];
        yield [
            3,
            ['hello' => 'world', 'quick' => 'brown', 'fox' => ''],
        ];
        yield [
            1,
            new BagConstructorTestCase(),
        ];
    }

    /**
     * Test that bag knows its length
     */
    #[DataProvider('__validData')]
    public function testBagIsCanBeIteratedOver(int $expected, BagConstructorTestCase|array $bag): void
    {
        $this->assertCount($expected, $this->utility($bag));
        $this->assertCount($expected, $this->utility($bag));
    }
}
