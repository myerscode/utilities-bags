<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class ValuesTest extends BaseBagSuite
{
    public function test_returns_bag_values_only(): void
    {
        $this->assertEquals([7, 49, 'Gerald', 'Rupert'], $this->utility([0 => 7, 77 => 49, 'ball_chaser' => 'Gerald', 'ham_eater' => 'Rupert'])->values());
    }
}
