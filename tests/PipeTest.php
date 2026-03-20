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
}
