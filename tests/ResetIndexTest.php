<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ResetIndexTest extends BaseBagSuite
{
    public function testBagCanResetIndexes(): void
    {
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $utility = $this->utility($values)->filter(fn ($value): bool => $value >= 4 && $value <= 6);

        $this->assertNotSame([4, 5, 6], $utility->value());

        $this->assertSame([4, 5, 6], $utility->resetIndex()->value());
    }

    public function testBagCanResetWithAssociativeData(): void
    {
        $values = [1, 2, 3, 'owner' => 'Fred', 'corgi_1' => 'Gerald', 7 => 7, 49 => 49];

        $this->assertSame(['owner' => 'Fred', 'corgi_1' => 'Gerald', 1, 2, 3, 7, 49], $this->utility($values)->resetIndex()->value());
    }
}
