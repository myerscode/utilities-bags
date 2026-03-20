<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class ChunkTest extends BaseBagSuite
{
    public function test_chunk_empty_bag(): void
    {
        $this->assertSame([], $this->utility([])->chunk(2)->toArray());
    }
    public function test_chunk_splits_bag(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5]);
        $chunks = $bag->chunk(2);

        $this->assertCount(3, $chunks);
        $this->assertInstanceOf(Utility::class, $chunks->get(0));
        $this->assertSame([0 => 1, 1 => 2], $chunks->get(0)->toArray());
        $this->assertSame([2 => 3, 3 => 4], $chunks->get(1)->toArray());
        $this->assertSame([4 => 5], $chunks->get(2)->toArray());
    }

    public function test_chunk_with_exact_division(): void
    {
        $bag = $this->utility([1, 2, 3, 4]);
        $chunks = $bag->chunk(2);
        $this->assertCount(2, $chunks);
    }

    public function test_chunk_with_size_larger_than_bag(): void
    {
        $bag = $this->utility([1, 2]);
        $chunks = $bag->chunk(10);
        $this->assertCount(1, $chunks);
        $this->assertSame([0 => 1, 1 => 2], $chunks->get(0)->toArray());
    }

    public function test_chunk_with_zero_size_returns_empty(): void
    {
        $this->assertSame([], $this->utility([1, 2, 3])->chunk(0)->toArray());
    }
}
