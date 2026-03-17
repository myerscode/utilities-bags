<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class FlattenTest extends BaseBagSuite
{
    public function test_can_flatten_with_custom_separator(): void
    {
        $values = [
            'deep' => [
                'nested' => [
                    'values' => [
                        'hello',
                        'world',
                    ],
                ],
            ],
            'foo' => 'bar',
            'single' => ['value' => 49],
        ];

        $utility = $this->utility($values)->flatten('_');

        $this->assertArrayHasKey('deep_nested_values_0', $utility);
        $this->assertArrayHasKey('deep_nested_values_1', $utility);
        $this->assertArrayHasKey('foo', $utility);
        $this->assertArrayHasKey('single_value', $utility);
    }

    public function test_flatten(): void
    {
        $values = [
            'deep' => [
                'nested' => [
                    'values' => [
                        'hello',
                        'world',
                    ],
                ],
            ],
            'foo' => 'bar',
            'single' => ['value' => 49],
        ];

        $utility = $this->utility($values)->flatten();
        $this->assertArrayHasKey('deep.nested.values.0', $utility);
        $this->assertArrayHasKey('deep.nested.values.1', $utility);
        $this->assertArrayHasKey('foo', $utility);
        $this->assertArrayHasKey('single.value', $utility);
    }
}
