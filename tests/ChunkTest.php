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

    public function test_chunk_of_size_one(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $chunks = $bag->chunk(1);
        $this->assertCount(3, $chunks);
    }

    public function test_chunk_preserves_associative_keys(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $chunks = $bag->chunk(2);
        $this->assertSame(['a' => 1, 'b' => 2], $chunks->get(0)->toArray());
        $this->assertSame(['c' => 3, 'd' => 4], $chunks->get(1)->toArray());
    }

    public function test_chunk_single_element(): void
    {
        $chunks = $this->utility([42])->chunk(5);
        $this->assertCount(1, $chunks);
        $this->assertSame([0 => 42], $chunks->get(0)->toArray());
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

    public function test_chunk_with_mixed_types(): void
    {
        $bag = $this->utility([null, 'hello', 42, true]);
        $chunks = $bag->chunk(2);
        $this->assertCount(2, $chunks);
        $this->assertSame([0 => null, 1 => 'hello'], $chunks->get(0)->toArray());
        $this->assertSame([2 => 42, 3 => true], $chunks->get(1)->toArray());
    }

    public function test_chunk_with_negative_size_returns_empty(): void
    {
        $this->assertSame([], $this->utility([1, 2])->chunk(-1)->toArray());
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
