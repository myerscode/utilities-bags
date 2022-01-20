<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class FlattenTest extends BaseBagSuite
{
    public function testCanFlattenWithCustomSeparator(): void
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

        $flat = $this->utility($values)->flatten('_');

        $this->assertArrayHasKey('deep_nested_values_0', $flat);
        $this->assertArrayHasKey('deep_nested_values_1', $flat);
        $this->assertArrayHasKey('foo', $flat);
        $this->assertArrayHasKey('single_value', $flat);
    }

    public function testFlatten(): void
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

        $flat = $this->utility($values)->flatten();
        $this->assertArrayHasKey('deep.nested.values.0', $flat);
        $this->assertArrayHasKey('deep.nested.values.1', $flat);
        $this->assertArrayHasKey('foo', $flat);
        $this->assertArrayHasKey('single.value', $flat);
    }
}
