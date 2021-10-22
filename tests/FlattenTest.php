<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass \Myerscode\Utilities\Bags\Utility
 */
class FlattenTest extends BaseBagSuite
{

    /**
     * @covers ::flatten
     */
    public function testFlatten()
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

    /**
     * @covers ::flatten
     */
    public function testCanFlattenWithCustomSeparator()
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
}
