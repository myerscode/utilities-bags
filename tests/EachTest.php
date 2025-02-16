<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class EachTest extends BaseBagSuite
{
    public function test_bag_iterates_over_each_value(): void
    {
        $counter = 0;
        $values = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $this->utility($values)->each(function ($value) use (&$counter) {
            $counter++;

            return $value;
        });

        $this->assertEquals(10, $counter);
    }
}
