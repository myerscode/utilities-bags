<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class SomeTest extends BaseBagSuite
{
    public function testSomeEmptyBagReturnsFalse(): void
    {
        $this->assertFalse($this->utility([])->some(fn (mixed $value): bool => true));
    }

    public function testSomeFalseWhenNoValueMatches(): void
    {
        $utility = $this->utility([1, 3, 5]);
        $this->assertFalse($utility->some(fn (int $value): bool => $value % 2 === 0));
    }

    public function testSomeReceivesKey(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2]);
        $this->assertTrue($utility->some(fn (int $value, string $key): bool => $key === 'b'));
    }

    public function testSomeSingleValue(): void
    {
        $this->assertTrue($this->utility([10])->some(fn (int $value): bool => $value > 5));
        $this->assertFalse($this->utility([3])->some(fn (int $value): bool => $value > 5));
    }

    public function testSomeTrueWhenOneValueMatches(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertTrue($utility->some(fn (int $value): bool => $value === 2));
    }
}
