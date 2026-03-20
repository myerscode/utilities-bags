<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class ToArrayTest extends BaseBagSuite
{
    /**
     * Test that toArray returns all the bag data as an array
     */
    public function testBagReturnsDataAsArray(): void
    {
        $this->assertSame([1, 2, 3], $this->utility([1, 2, 3])->toArray());
        $this->assertSame(['hello' => 'world'], $this->utility(['hello' => 'world'])->toArray());
    }
}
