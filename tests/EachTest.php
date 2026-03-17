<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class EachTest extends BaseBagSuite
{
    public function test_bag_iterates_over_each_value(): void
    {
        $counter = 0;
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $this->utility($values)->each(function ($value) use (&$counter) {
            $counter++;

            return $value;
        });

        $this->assertSame(10, $counter);
    }
}
