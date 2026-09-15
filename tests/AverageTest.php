<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class AverageTest extends BaseBagSuite
{
    public function testAverageAliasesAvg(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame($utility->avg(), $utility->average());
    }

    public function testAverageByKey(): void
    {
        $utility = $this->utility([
            ['foo' => 10],
            ['foo' => 20],
            ['foo' => 60],
        ]);

        $this->assertSame(30, $utility->average('foo'));
    }

    public function testAverageEmptyBagReturnsNull(): void
    {
        $this->assertNull($this->utility([])->average());
    }

    public function testAverageOfIntegers(): void
    {
        // PHP division yields an int when the result is whole
        $this->assertSame(2, $this->utility([1, 2, 3])->average());
    }
}
