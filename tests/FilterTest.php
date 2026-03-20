<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FilterTest extends BaseBagSuite
{
    public function test_bag_filters_based_on_provided_key_condition(): void
    {
        $values = ['corgi' => 'Gerald', 'owner' => 'Fred'];
        $this->assertSame(['owner' => 'Fred'], $this->utility($values)->filter(fn ($value, $key): bool => $key === 'owner')->value());
    }

    public function test_bag_filters_based_on_provided_value_condition(): void
    {
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        $this->assertSame([1, 2, 3, 4, 9 => 0], $this->utility($values)->filter(fn ($value): bool => $value < 5)->value());
    }

    public function test_bag_filters_by_key_only(): void
    {
        $values = ['foo' => 'bar', 'hello' => 'world', 'baz' => 'qux'];
        $result = $this->utility($values)->filter(fn ($key): bool => $key !== 'hello', ARRAY_FILTER_USE_KEY)->value();
        $this->assertSame(['foo' => 'bar', 'baz' => 'qux'], $result);
    }

    public function test_bag_filters_empty_values(): void
    {
        $values = [7, 49, 42, 69, false, null, 0];

        $this->assertSame([7, 49, 42, 69], $this->utility($values)->filter()->value());
    }
}
