<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class FilterTest extends BaseBagSuite
{
    public function testBagFiltersEmptyValues(): void
    {
        $values = [7, 49, 42, 69, false, null, 0];

        $this->assertEquals([7, 49, 42, 69], $this->utility($values)->filter()->value());
    }

    public function testBagFiltersBasedOnProvidedValueCondition(): void
    {
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        $this->assertEquals([1,2,3,4, 9 => 0], $this->utility($values)->filter(fn($value): bool => $value < 5)->value());
    }

    public function testBagFiltersBasedOnProvidedKeyCondition(): void
    {
        $values = ['corgi' => 'Gerald', 'owner' => 'Fred'];
        $this->assertEquals(['owner' => 'Fred'], $this->utility($values)->filter(fn($value, $key): bool => $key === 'owner')->value());
    }
}
