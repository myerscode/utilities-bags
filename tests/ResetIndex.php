<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ResetIndex extends BaseBagSuite
{
    public function testBagCanResetIndexes(): void
    {
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $bag = $this->utility($values)->filter(function ($value) {
            return ($value >= 4 && $value <= 6);
        });

        $this->assertNotEquals([4, 5, 6], $bag->value());

        $this->assertEquals([4, 5, 6], $bag->resetIndex()->value());
    }

    public function testBagCanResetWithAssociativeData(): void
    {
        $values = [1, 2, 3, 'owner' => 'Fred', 'corgi_1' => 'Gerald', 7 => 7, 49 => 49];

        $this->assertEquals([1, 2, 3, 7, 49, 'owner' => 'Fred', 'corgi_1' => 'Gerald'], $this->utility($values)->resetIndex()->value());
    }
}
