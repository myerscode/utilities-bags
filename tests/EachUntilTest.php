<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\BaseBagSuite;
use Iterator;

final class EachUntilTest extends BaseBagSuite
{
    public static function __testData(): Iterator
    {
        yield [
            7,
            7,
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
        ];
        yield [
            10,
            49,
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
        ];
    }

    #[DataProvider('__testData')]
    public function testBagIteratesOverEachValueUtilStopValueIsReturned(int $expected, int $stopOn, array $values): void
    {
        $counter = 0;

        $this->utility($values)->eachUtil(function ($value) use (&$counter) {
            $counter++;

            return $value;
        }, $stopOn);

        $this->assertSame($expected, $counter);
    }
}
