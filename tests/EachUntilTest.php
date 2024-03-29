<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class EachUntilTest extends BaseBagSuite
{
    public function __testData(): array
    {
        return [
            [
                7,
                7,
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
            ],
            [
                10,
                49,
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
            ],
        ];
    }

    /**
     * @dataProvider  __testData
     */
    public function testBagIteratesOverEachValueUtilStopValueIsReturned($expected, $stopOn, $values): void
    {
        $counter = 0;

        $this->utility($values)->eachUtil(function ($value) use (&$counter) {
            $counter++;

            return $value;
        }, $stopOn);

        $this->assertEquals($expected, $counter);
    }
}

