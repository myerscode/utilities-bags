<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class PartitionTest extends BaseBagSuite
{
    public function testPartitionAllMatch(): void
    {
        $utility = $this->utility([2, 4, 6]);
        [$passed, $failed] = $utility->partition(fn (int $value): bool => $value % 2 === 0)->values();

        $this->assertSame([2, 4, 6], $passed->toArray());
        $this->assertSame([], $failed->toArray());
    }

    public function testPartitionEmptyBag(): void
    {
        [$passed, $failed] = $this->utility([])->partition(fn (mixed $value): bool => true)->values();

        $this->assertSame([], $passed->toArray());
        $this->assertSame([], $failed->toArray());
    }

    public function testPartitionNoneMatch(): void
    {
        $utility = $this->utility([1, 3, 5]);
        [$passed, $failed] = $utility->partition(fn (int $value): bool => $value % 2 === 0)->values();

        $this->assertSame([], $passed->toArray());
        $this->assertSame([1, 3, 5], $failed->toArray());
    }

    public function testPartitionReceivesKey(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2, 'c' => 3]);
        [$passed, $failed] = $utility->partition(fn (int $value, string $key): bool => $key === 'b')->values();

        $this->assertSame(['b' => 2], $passed->toArray());
        $this->assertSame(['a' => 1, 'c' => 3], $failed->toArray());
    }

    public function testPartitionReturnsBagOfTwoBags(): void
    {
        $result = $this->utility([1, 2, 3, 4])->partition(fn (int $value): bool => $value > 2);

        $this->assertInstanceOf(Utility::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Utility::class, $result->get(0));
        $this->assertInstanceOf(Utility::class, $result->get(1));
    }

    public function testPartitionSplitsValues(): void
    {
        $utility = $this->utility([1, 2, 3, 4, 5, 6]);
        [$passed, $failed] = $utility->partition(fn (int $value): bool => $value % 2 === 0)->values();

        $this->assertSame([1 => 2, 3 => 4, 5 => 6], $passed->toArray());
        $this->assertSame([0 => 1, 2 => 3, 4 => 5], $failed->toArray());
    }
}
