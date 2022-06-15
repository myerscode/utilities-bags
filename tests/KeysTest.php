<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class KeysTest extends BaseBagSuite
{
    public function testCanGetKeys(): void
    {
        $values = [1, 2, 7 => 49, 49 => 7, 'corgi_1' => 'Gerald', 'corgi_2' => 'Rupert'];

        $this->assertEquals([0, 1, 7, 49, 'corgi_1', 'corgi_2'], $this->utility($values)->keys());
    }
}
