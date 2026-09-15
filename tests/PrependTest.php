<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class PrependTest extends BaseBagSuite
{
    public function testPrependOntoEmptyBag(): void
    {
        $this->assertSame(['foo'], $this->utility([])->prepend('foo')->toArray());
    }

    public function testPrependReindexesSequentialValues(): void
    {
        // prepending without a key onto an integer-keyed bag re-bases the values
        $utility = $this->utility([5 => 'a', 6 => 'b']);
        $this->assertSame(['x', 'a', 'b'], $utility->prepend('x')->toArray());
    }

    public function testPrependReturnsNewInstance(): void
    {
        $utility = $this->utility([1, 2, 3]);
        $prepended = $utility->prepend(0);
        $this->assertNotSame($utility, $prepended);
        $this->assertSame([1, 2, 3], $utility->toArray());
    }

    public function testPrependValueOntoSequentialBag(): void
    {
        $this->assertSame(['zero', 'one', 'two'], $this->utility(['one', 'two'])->prepend('zero')->toArray());
    }

    public function testPrependWithExistingKeyOverridesAtFront(): void
    {
        $utility = $this->utility(['a' => 1, 'b' => 2]);
        $this->assertSame(['a' => 99, 'b' => 2], $utility->prepend(99, 'a')->toArray());
    }

    public function testPrependWithKey(): void
    {
        $utility = $this->utility(['b' => 2, 'c' => 3]);
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $utility->prepend(1, 'a')->toArray());
    }

    public function testPrependWithKeyOntoEmptyBag(): void
    {
        $this->assertSame(['a' => 1], $this->utility([])->prepend(1, 'a')->toArray());
    }
}
