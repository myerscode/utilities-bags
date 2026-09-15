<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class EveryTest extends BaseBagSuite
{
    public function testEveryEmptyBagReturnsTrue(): void
    {
        $this->assertTrue($this->utility([])->every(fn (mixed $value): bool => false));
    }

    public function testEveryFalseWhenOneValueFails(): void
    {
        $utility = $this->utility([2, 4, 5, 6]);
        $this->assertFalse($utility->every(fn (int $value): bool => $value % 2 === 0));
    }

    public function testEveryReceivesKey(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2]);
        $this->assertTrue($utility->every(fn (int $value, string $key): bool => is_string($key)));
    }

    public function testEverySingleValue(): void
    {
        $this->assertTrue($this->utility([10])->every(fn (int $value): bool => $value > 5));
        $this->assertFalse($this->utility([3])->every(fn (int $value): bool => $value > 5));
    }

    public function testEveryTrueWhenAllValuesPass(): void
    {
        $utility = $this->utility([2, 4, 6, 8]);
        $this->assertTrue($utility->every(fn (int $value): bool => $value % 2 === 0));
    }
}
