<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class ChunkTest extends BaseBagSuite
{
    public function testChunkEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->chunk(2)->toArray());
    }

    public function testChunkOfSizeOne(): void
    {
        $bag = $this->utility([1, 2, 3]);
        $chunks = $bag->chunk(1);
        $this->assertCount(3, $chunks);
    }

    public function testChunkPreservesAssociativeKeys(): void
    {
        $bag = $this->utility(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $chunks = $bag->chunk(2);
        $this->assertSame(['a' => 1, 'b' => 2], $chunks->get(0)->toArray());
        $this->assertSame(['c' => 3, 'd' => 4], $chunks->get(1)->toArray());
    }

    public function testChunkSingleElement(): void
    {
        $chunks = $this->utility([42])->chunk(5);
        $this->assertCount(1, $chunks);
        $this->assertSame([0 => 42], $chunks->get(0)->toArray());
    }
    public function testChunkSplitsBag(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5]);
        $chunks = $bag->chunk(2);

        $this->assertCount(3, $chunks);
        $this->assertInstanceOf(Utility::class, $chunks->get(0));
        $this->assertSame([0 => 1, 1 => 2], $chunks->get(0)->toArray());
        $this->assertSame([2 => 3, 3 => 4], $chunks->get(1)->toArray());
        $this->assertSame([4 => 5], $chunks->get(2)->toArray());
    }

    public function testChunkWithExactDivision(): void
    {
        $bag = $this->utility([1, 2, 3, 4]);
        $chunks = $bag->chunk(2);
        $this->assertCount(2, $chunks);
    }

    public function testChunkWithMixedTypes(): void
    {
        $bag = $this->utility([null, 'hello', 42, true]);
        $chunks = $bag->chunk(2);
        $this->assertCount(2, $chunks);
        $this->assertSame([0 => null, 1 => 'hello'], $chunks->get(0)->toArray());
        $this->assertSame([2 => 42, 3 => true], $chunks->get(1)->toArray());
    }

    public function testChunkWithNegativeSizeReturnsEmpty(): void
    {
        $this->assertSame([], $this->utility([1, 2])->chunk(-1)->toArray());
    }

    public function testChunkWithSizeLargerThanBag(): void
    {
        $bag = $this->utility([1, 2]);
        $chunks = $bag->chunk(10);
        $this->assertCount(1, $chunks);
        $this->assertSame([0 => 1, 1 => 2], $chunks->get(0)->toArray());
    }

    public function testChunkWithZeroSizeReturnsEmpty(): void
    {
        $this->assertSame([], $this->utility([1, 2, 3])->chunk(0)->toArray());
    }
}
