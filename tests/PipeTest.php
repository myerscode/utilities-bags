<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class PipeTest extends BaseBagSuite
{
    public function testPipeCanReturnAnyType(): void
    {
        $result = $this->utility(['hello', 'world'])->pipe(fn (Utility $bag): string => $bag->join(' '));
        $this->assertSame('hello world', $result);
    }

    public function testPipeCanReturnArray(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): array => $bag->toArray());
        $this->assertSame([1, 2, 3], $result);
    }

    public function testPipeCanReturnNewBag(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): Utility => $bag->push(4));
        $this->assertInstanceOf(Utility::class, $result);
        $this->assertSame([1, 2, 3, 4], $result->toArray());
    }
    public function testPipePassesBagToCallback(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): int => $bag->count());
        $this->assertSame(3, $result);
    }

    public function testPipeReceivesOriginalBag(): void
    {
        $bag = $this->utility(['a', 'b', 'c']);
        $bag->pipe(function (Utility $received) use ($bag): void {
            $this->assertSame($bag->toArray(), $received->toArray());
        });
    }

    public function testPipeReturnsNull(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $bag): mixed => null);
        $this->assertNull($result);
    }

    public function testPipeWithEmptyBag(): void
    {
        $result = $this->utility([])->pipe(fn (Utility $bag): bool => $bag->isEmpty());
        $this->assertTrue($result);
    }
}
