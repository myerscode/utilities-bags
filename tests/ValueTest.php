<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ValueTest extends BaseBagSuite
{
    /**
     * Test that value returns all the bag data as an array
     */
    public function test_value_returns_data_as_array(): void
    {
        $this->assertSame([1, 2, 3], $this->utility([1, 2, 3])->value());
        $this->assertSame(['hello' => 'world'], $this->utility(['hello' => 'world'])->value());
    }
}
