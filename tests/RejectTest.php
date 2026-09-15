<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class RejectTest extends BaseBagSuite
{
    public function testRejectAllReturnsEmpty(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([], $utility->reject(fn (int $value): bool => true)->toArray());
    }

    public function testRejectByKeyMode(): void
    {
        $utility = $this->utility(['keep' => 1, 'drop' => 2]);
        $result = $utility->reject(fn (string $key): bool => $key === 'drop', ARRAY_FILTER_USE_KEY);
        $this->assertSame(['keep' => 1], $result->toArray());
    }

    public function testRejectByValueOnlyMode(): void
    {
        $utility = $this->utility([1, 2, 3, 4]);
        $result = $utility->reject(fn (int $value): bool => $value > 2, 0);
        $this->assertSame([0 => 1, 1 => 2], $result->toArray());
    }
    public function testRejectEmptyBag(): void
    {
        $result = $this->utility([])->reject(fn (mixed $value): bool => true);
        $this->assertSame([], $result->toArray());
    }

    public function testRejectKeepsItemsWhereCallbackIsFalse(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5, 6]);
        $result = $utility->reject(fn (int $value): bool => $value % 2 === 0);
        $this->assertSame([0 => 1, 2 => 3, 4 => 5], $result->toArray());
    }

    public function testRejectNoneKeepsEverything(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame([1, 2, 3], $utility->reject(fn (int $value): bool => false)->toArray());
    }

    public function testRejectReceivesKeyWithDefaultMode(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        $result = $utility->reject(fn (int $value, string $key): bool => $key === 'b');
        $this->assertSame(['a' => 1, 'c' => 3], $result->toArray());
    }

    public function testRejectReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->reject(fn (int $value): bool => $value === 2);
        $this->assertNotSame($utility, $result);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }
}
