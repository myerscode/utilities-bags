<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class PipeTest extends BaseBagSuite
{
    public function testPipeCanReturnAnyType(): void
    {
        $result = $this->utility(['hello', 'world'])->pipe(fn (Utility $utility): string => $utility->join(' '));
        $this->assertSame('hello world', $result);
    }

    public function testPipeCanReturnArray(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $utility): array => $utility->toArray());
        $this->assertSame([1, 2, 3], $result);
    }

    public function testPipeCanReturnNewBag(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $utility): Utility => $utility->push(4));
        $this->assertInstanceOf(Utility::class, $result);
        $this->assertSame([1, 2, 3, 4], $result->toArray());
    }

    public function testPipePassesBagToCallback(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $utility): int => $utility->count());
        $this->assertSame(3, $result);
    }

    public function testPipeReceivesOriginalBag(): void
    {
        $utility = $this->utility(['a', 'b', 'c']);
        $utility->pipe(function (Utility $received) use ($utility): void {
            $this->assertSame($utility->toArray(), $received->toArray());
        });
    }

    public function testPipeReturnsNull(): void
    {
        $result = $this->utility([1, 2, 3])->pipe(fn (Utility $utility): mixed => null);
        $this->assertNull($result);
    }

    public function testPipeWithEmptyBag(): void
    {
        $result = $this->utility([])->pipe(fn (Utility $utility): bool => $utility->isEmpty());
        $this->assertTrue($result);
    }
}
