<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class SetTest extends BaseBagSuite
{
    public function testValueSetToBagViaSet()
    {
        // check can add to empty bag
        $bag = $this->utility([])->set(0, 'foo')->value();
        $this->assertEquals([0 => 'foo'], $bag);

        //check value is not overwritten
        $bag = $this->utility([0 => 'foo'])->set(0, 'bar')->value();
        $this->assertEquals([0 => 'bar'], $bag);

        // check value can be added
        $bag = $this->utility([0 => 'foo'])->set(1, 'bar')->value();
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag);

        // check indexes can be mixed
        $bag = $this->utility(['foo' => 'bar'])->set(0, 'foo')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);

        // check can use key index
        $bag = $this->utility([0 => 'foo'])->set('foo', 'bar')->value();
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag);

        // dot notation is not applied
        $bag = $this->utility([])->set('foo.bar', 'hello world')->value();
        $this->assertEquals(['foo.bar' => 'hello world'], $bag);
    }

    public function testValueSetToBagViaOffsetSet()
    {
        // check can add to empty bag
        $bag = $this->utility([]);
        $bag->offsetSet(0, 'foo');
        $this->assertEquals([0 => 'foo'], $bag->value());

        //check value is not overwritten
        $bag = $this->utility([0 => 'foo']);
        $bag->offsetSet(0, 'bar');
        $this->assertEquals([0 => 'bar'], $bag->value());

        // check value can be added
        $bag = $this->utility([0 => 'foo']);
        $bag->offsetSet(1, 'bar');
        $this->assertEquals([0 => 'foo', 1 => 'bar'], $bag->value());

        // check indexes can be mixed
        $bag = $this->utility(['foo' => 'bar']);
        $bag->offsetSet(0, 'foo');
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag->value());

        // check can use key index
        $bag = $this->utility([0 => 'foo']);
        $bag->offsetSet('foo', 'bar');
        $this->assertEquals(['foo' => 'bar', 0 => 'foo'], $bag->value());
    }

    public function testSetValueByDotNotation()
    {
        $values = [
            'deep' => [
                'nested' => [
                    'values' => [
                        'hello',
                    ],
                ],
            ],
        ];

        $bag = $this->dot($values)->set('deep.nested.values', 'hello world');

        $this->assertEquals([
            'deep' => [
                'nested' => [
                    'values' => 'hello world',
                ],
            ],
        ], $bag->value());

        $bag = $this->dot($values)->set('foo.bar', 'hello world');

        $this->assertEquals([
            'deep' => [
                'nested' => [
                    'values' => [
                        'hello',
                    ],
                ],
            ],
            'foo' => [
                'bar' => 'hello world',
            ],
        ], $bag->value());
    }
}
