<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ExistsTest extends BaseBagSuite
{

    /**
     * @covers ::exists
     */
    public function testExists()
    {
        $this->assertTrue($this->utility([0 => 'hello', 100 => 'foo'])->exists(100));

        $this->assertFalse($this->utility([])->exists(100));

        $this->assertTrue($this->utility(['foo' => 'bar'])->exists('foo'));

        $this->assertFalse($this->utility(['hello' => 'world', 0 => 'foo'])->exists('foo'));
    }

    /**
     * @covers ::offsetExists
     */
    public function testOffsetExists()
    {
        $this->assertTrue($this->utility([0 => 'hello', 100 => 'foo'])->offsetExists(100));

        $this->assertFalse($this->utility([])->offsetExists(100));

        $this->assertTrue($this->utility(['foo' => 'bar'])->offsetExists('foo'));

        $this->assertFalse($this->utility(['hello' => 'world', 0 => 'foo'])->offsetExists('foo'));
    }
}
