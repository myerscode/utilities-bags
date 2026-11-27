<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use Tests\Support\BaseBagSuite;

final class RemoveTest extends BaseBagSuite
{
    public function testDotUtilityIgnoresMissingKey(): void
    {
        $bag = $this->dot(['Rupert' => ['age' => 30]]);

        $this->assertSame(['Rupert' => ['age' => 30]], $bag->remove('Rupert.town')->value());
    }

    public function testDotUtilityRemoveDoesNotChangeOriginal(): void
    {
        $bag = $this->dot(['Rupert' => ['age' => 30]]);
        $bag->remove('Rupert.age');

        $this->assertSame(['Rupert' => ['age' => 30]], $bag->value());
    }

    public function testDotUtilityRemoveReturnsDotUtility(): void
    {
        $this->assertInstanceOf(DotUtility::class, $this->dot(['Rupert' => ['age' => 30]])->remove('Rupert.age'));
    }

    public function testDotUtilityRemovesDeeplyNestedKey(): void
    {
        $bag = $this->dot(['Rupert' => ['Gerald' => ['Arthur' => 'Leeds', 'town' => 'York']]]);

        $this->assertSame(['Rupert' => ['Gerald' => ['town' => 'York']]], $bag->remove('Rupert.Gerald.Arthur')->value());
    }

    public function testDotUtilityRemovesNestedKey(): void
    {
        $bag = $this->dot(['Rupert' => ['age' => 30, 'town' => 'Leeds'], 'Gerald' => 'York']);

        $this->assertSame(
            ['Rupert' => ['town' => 'Leeds'], 'Gerald' => 'York'],
            $bag->remove('Rupert.age')->value()
        );
    }
    public function testOffsetUnset(): void
    {
        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(0);
        $this->assertSame([1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo', 'bar']);
        $bag->offsetUnset(100);
        $this->assertSame([0 => 'foo', 1 => 'bar'], $bag->value());

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar']);
        $bag->offsetUnset('foo');
        $this->assertSame([0 => 'foo', 'hello' => 'world', 1 => 'bar'], $bag->value());
    }

    public function testRemove(): void
    {
        $bag = $this->utility(['foo', 'bar'])->remove(0)->value();
        $this->assertSame([1 => 'bar'], $bag);

        $bag = $this->utility(['foo', 'bar'])->remove(100)->value();
        $this->assertSame([0 => 'foo', 1 => 'bar'], $bag);

        $bag = $this->utility(['foo' => 'bar', 'foo', 'hello' => 'world', 'bar'])->remove('foo')->value();
        $this->assertSame([0 => 'foo', 'hello' => 'world', 1 => 'bar'], $bag);
    }
}
