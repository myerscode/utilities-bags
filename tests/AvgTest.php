<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class AvgTest extends BaseBagSuite
{
    public function testAvgByCallback(): void
    {
        $utility = $this->utility([
            ['score' => 10],
            ['score' => 20],
            ['score' => 30],
        ]);

        $this->assertSame(20, $utility->avg(fn (array $item): int => $item['score']));
    }

    public function testAvgByKey(): void
    {
        $utility = $this->utility([
            ['foo' => 10],
            ['foo' => 20],
            ['foo' => 60],
        ]);

        $this->assertSame(30, $utility->avg('foo'));
    }

    public function testAvgEmptyBagReturnsNull(): void
    {
        $this->assertNull($this->utility([])->avg());
    }

    public function testAvgOfFloats(): void
    {
        $this->assertSame(2.5, $this->utility([1.0, 2.0, 3.0, 4.0])->avg());
    }

    public function testAvgOfIntegers(): void
    {
        // PHP division yields an int when the result is whole
        $this->assertSame(2, $this->utility([1, 2, 3])->avg());
    }

    public function testAvgReturnsFloatWhenNotWhole(): void
    {
        $this->assertSame(2.5, $this->utility([1, 2, 3, 4])->avg());
    }

    public function testAvgSingleValue(): void
    {
        $this->assertSame(5, $this->utility([5])->avg());
    }

    public function testAvgWithMissingKeyTreatsAsZero(): void
    {
        $utility = $this->utility([
            ['foo' => 10],
            ['bar' => 20],
        ]);

        // second row has no 'foo' key, so it resolves to null (0 when summed)
        $this->assertSame(5, $utility->avg('foo'));
    }
}
