<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ValuesTest extends BaseBagSuite
{
    public function test_returns_bag_values_only(): void
    {
        $this->assertSame([7, 49, 'Gerald', 'Rupert'], $this->utility([0 => 7, 77 => 49, 'ball_chaser' => 'Gerald', 'ham_eater' => 'Rupert'])->values());
    }
}
