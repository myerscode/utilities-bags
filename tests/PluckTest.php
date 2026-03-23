<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class PluckTest extends BaseBagSuite
{
    public function testPluckExtractsValues(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'age' => 30],
            ['name' => 'Tor', 'age' => 25],
        ]);
        $this->assertSame(['Fred', 'Tor'], $utility->pluck('name')->toArray());
    }

    public function testPluckOnEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->pluck('name')->toArray());
    }

    public function testPluckReturnsNullForMissingKeys(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred'],
            ['age' => 25],
        ]);
        $this->assertSame(['Fred', null], $utility->pluck('name')->toArray());
    }

    public function testPluckWithBooleanValues(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'active' => true],
            ['name' => 'Tor', 'active' => false],
        ]);
        $this->assertSame([true, false], $utility->pluck('active')->toArray());
    }

    public function testPluckWithDuplicateKeyPathValues(): void
    {
        $utility = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 1, 'name' => 'Tor'],
        ]);
        $result = $utility->pluck('name', 'id');
        $this->assertSame([1 => 'Tor'], $result->toArray());
    }

    public function testPluckWithKeyPath(): void
    {
        $utility = $this->utility([
            ['id' => 1, 'name' => 'Fred'],
            ['id' => 2, 'name' => 'Tor'],
        ]);
        $this->assertSame([1 => 'Fred', 2 => 'Tor'], $utility->pluck('name', 'id')->toArray());
    }

    public function testPluckWithMixedItemTypes(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred'],
            'not an array',
            ['name' => 'Tor'],
        ]);
        $this->assertSame(['Fred', null, 'Tor'], $utility->pluck('name')->toArray());
    }

    public function testPluckWithNullValuesInColumn(): void
    {
        $utility = $this->utility([
            ['name' => 'Fred', 'email' => null],
            ['name' => 'Tor', 'email' => 'tor@example.com'],
        ]);
        $this->assertSame([null, 'tor@example.com'], $utility->pluck('email')->toArray());
    }

    public function testPluckWithNumericStringKeys(): void
    {
        $utility = $this->utility([
            ['0' => 'zero', '1' => 'one'],
            ['0' => 'two', '1' => 'three'],
        ]);
        $this->assertSame(['zero', 'two'], $utility->pluck('0')->toArray());
    }
}
