<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass \Myerscode\Utilities\Bags\Utility
 */
class GetTest extends BaseBagSuite
{

    /**
     * @covers \Myerscode\Utilities\Bags\DotUtility::get
     */
    public function testDotValueRetrievedFromGet()
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

            'key' => [
                'with' => [
                    'dot' => 'value',
                ],
            ],

            'key.with.dot' => 'lives here',

        ];

        $this->assertEquals(['hello', 'world',], $this->dot($values)->get('deep.nested.values'));

        $this->assertEquals('lives here', $this->dot($values)->get('key.with.dot'));

        $this->assertEquals(null, $this->dot($values)->get('deep.nested.values.contains'));
    }

    /**
     * @covers \Myerscode\Utilities\Bags\DotUtility::get
     */
    public function testDotValueReturnsDefaultIfNotFound()
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
        ];

        $this->assertEquals(null, $this->dot($values)->get('deep.nested.values.contains'));

        $this->assertEquals([
            'nested' => [
                'values' => [
                    'hello',
                    'world',
                ],
            ],
        ], $this->dot($values)->get('deep'));

        $this->assertEquals('default-value', $this->dot($values)->get('deep.nested.values.contains', 'default-value'));
    }

    /**
     * @covers ::get
     */
    public function testValueRetrievedFromGet()
    {
        $this->assertEquals(null, $this->utility([])->get(100));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->get(2));

        $this->assertEquals('foo', $this->utility(['foo', 'bar'])->get(0));

        $this->assertEquals('world', $this->utility(['foo' => 'bar', 'hello' => 'world'])->get('hello'));

        $this->assertEquals('whoops', $this->utility(['foo', 'bar'])->get(2, 'whoops'));
    }

    /**
     * @covers ::offsetGet
     */
    public function testValueRetrievedFromOffsetGet()
    {
        $this->assertEquals(null, $this->utility([])->offsetGet(100));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->offsetGet(2));

        $this->assertEquals('foo', $this->utility(['foo', 'bar'])->offsetGet(0));

        $this->assertEquals('world', $this->utility(['foo' => 'bar', 'hello' => 'world'])->offsetGet('hello'));

        $this->assertEquals(null, $this->utility(['foo', 'bar'])->offsetGet(2));
    }
}
