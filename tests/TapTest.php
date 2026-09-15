<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class TapTest extends BaseBagSuite
{
    public function testTapAllowsChaining(): void
    {
        $seen = [];
        $result = $this->utility([1, 2, 3])
            ->tap(function (Utility $bag) use (&$seen): void {
                $seen[] = $bag->count();
            })
            ->map(fn (int $value): int => $value * 2);

        $this->assertSame([3], $seen);
        $this->assertSame([2, 4, 6], $result->toArray());
    }

    public function testTapDoesNotMutateBag(): void
    {
        $utility = $this->utility(['a' => 1]);
        $utility->tap(fn (Utility $bag): Utility => $bag->set('b', 2));
        $this->assertSame(['a' => 1], $utility->toArray());
    }

    public function testTapIgnoresCallbackReturnValue(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $result = $utility->tap(fn (Utility $bag): string => 'ignored');
        $this->assertSame([1, 2, 3], $result->toArray());
    }
    public function testTapPassesBagToCallback(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $received = null;

        $utility->tap(function (Utility $bag) use (&$received): void {
            $received = $bag;
        });

        $this->assertSame($utility, $received);
    }

    public function testTapReturnsSameInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $this->assertSame($utility, $utility->tap(fn (Utility $bag): mixed => $bag->count()));
    }
}
