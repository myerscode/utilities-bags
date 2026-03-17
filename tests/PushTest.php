<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class PushTest extends BaseBagSuite
{
    public function test_value_added_to_bag(): void
    {
        $bag = $this->utility([])->push('foo')->value();
        $this->assertSame(['foo'], $bag);

        $bag = $this->utility([])->push('foo', 'bar', 'hello', 'world')->value();
        $this->assertSame(['foo', 'bar', 'hello', 'world'], $bag);

        $bag = $this->utility(['foo'])->push('bar')->value();
        $this->assertSame(['foo', 'bar'], $bag);

        $bag = $this->utility([1 => 'foo'])->push('bar')->value();
        $this->assertSame([1 => 'foo', 2 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar'])->push('hello')->value();
        $this->assertSame(['foo' => 'bar', 0 => 'hello'], $bag);
    }
}
