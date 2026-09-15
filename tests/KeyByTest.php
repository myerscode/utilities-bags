<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class KeyByTest extends BaseBagSuite
{
    public function testKeyByCallback(): void
    {
        $utility = $this->utility([
            ['id' => 10, 'name' => 'Fred'],
            ['id' => 20, 'name' => 'Tor'],
        ]);

        $result = $utility->keyBy(fn (array $item): int => $item['id']);

        $this->assertSame([
            10 => ['id' => 10, 'name' => 'Fred'],
            20 => ['id' => 20, 'name' => 'Tor'],
        ], $result->toArray());
    }

    public function testKeyByEmptyBag(): void
    {
        $this->assertSame([], $this->utility([])->keyBy('id')->toArray());
    }

    public function testKeyByLastWinsOnDuplicateKey(): void
    {
        $utility = $this->utility([
            ['type' => 'a', 'value' => 1],
            ['type' => 'a', 'value' => 2],
            ['type' => 'b', 'value' => 3],
        ]);

        $result = $utility->keyBy('type');

        $this->assertSame([
            'a' => ['type' => 'a', 'value' => 2],
            'b' => ['type' => 'b', 'value' => 3],
        ], $result->toArray());
    }

    public function testKeyByReturnsNewInstance(): void
    {
        $utility = $this->utility([['id' => 1]]);
        $result = $utility->keyBy('id');
        $this->assertNotSame($utility, $result);
        $this->assertSame([['id' => 1]], $utility->toArray());
    }

    public function testKeyByStringKey(): void
    {
        $utility = $this->utility([
            ['code' => 'GB', 'name' => 'Britain'],
            ['code' => 'FR', 'name' => 'France'],
        ]);

        $result = $utility->keyBy('code');

        $this->assertSame(['GB', 'FR'], $result->keys());
    }
}
