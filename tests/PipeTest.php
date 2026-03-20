<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class PipeTest extends BaseBagSuite
{
    public function test_pipe_can_return_any_type(): void
    {
        $result = $this->utility(['hello', 'world'])->pipe(fn (Utility $bag): string => $bag->join(' '));
        $this->assertSame('hello world', $result);
    }

    public function test_pipe_can_return_array(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): array => $bag->toArray());
        $this->assertSame([1, 2, 3], $result);
    }

    public function test_pipe_can_return_new_bag(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): Utility => $bag->push(4));
        $this->assertInstanceOf(Utility::class, $result);
        $this->assertSame([1, 2, 3, 4], $result->toArray());
    }
    public function test_pipe_passes_bag_to_callback(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): int => $bag->count());
        $this->assertSame(3, $result);
    }

    public function test_pipe_receives_original_bag(): void
    {
        $bag = $this->utility(['a', 'b', 'c']);
        $bag->pipe(function (Utility $received) use ($bag): void {
            $this->assertSame($bag->toArray(), $received->toArray());
        });
    }

    public function test_pipe_returns_null(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): mixed => null);
        $this->assertNull($result);
    }

    public function test_pipe_with_empty_bag(): void
    {
        $result = $this->utility([])->pipe(fn (Utility $bag): bool => $bag->isEmpty());
        $this->assertTrue($result);
    }
}
