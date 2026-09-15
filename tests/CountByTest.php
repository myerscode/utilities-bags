<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class CountByTest extends BaseBagSuite
{
    public function testCountByCallback(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5, 6]);
        $result = $utility->countBy(fn (int $value): string => $value % 2 === 0 ? 'even' : 'odd');
        $this->assertSame(['odd' => 3, 'even' => 3], $result->toArray());
    }

    public function testCountByEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->countBy()->toArray());
    }

    public function testCountByKey(): void
    {
        $utility = $this->utility([
            ['type' => 'a'],
            ['type' => 'b'],
            ['type' => 'a'],
            ['type' => 'a'],
        ]);

        $this->assertSame(['a' => 3, 'b' => 1], $utility->countBy('type')->toArray());
    }

    public function testCountByReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 1, 2]);
        $result = $utility->countBy();
        $this->assertNotSame($utility, $result);
        $this->assertSame([1, 1, 2], $utility->toArray());
    }

    public function testCountByValuesWithNoArgument(): void
    {
        $utility = $this->utility(['apple', 'pear', 'apple', 'apple', 'pear']);
        $this->assertSame(['apple' => 3, 'pear' => 2], $utility->countBy()->toArray());
    }
}
