<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

final class GroupByTest extends BaseBagSuite
{
    public function test_group_by_callback(): void
    {
        $bag = $this->utility([1, 2, 3, 4, 5, 6]);
        $grouped = $bag->groupBy(fn (int $value): string => $value % 2 === 0 ? 'even' : 'odd');

        $this->assertSame([1, 3, 5], $grouped->get('odd')->toArray());
        $this->assertSame([2, 4, 6], $grouped->get('even')->toArray());
    }

    public function test_group_by_on_empty_bag(): void
    {
        $this->assertSame([], $this->utility([])->groupBy('key')->toArray());
    }

    public function test_group_by_preserves_all_items(): void
    {
        $items = [
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor', 'role' => 'dev'],
            ['name' => 'Chris', 'role' => 'design'],
        ];
        $bag = $this->utility($items);
        $grouped = $bag->groupBy('role');

        $totalItems = $grouped->get('dev')->count() + $grouped->get('design')->count();
        $this->assertSame(3, $totalItems);
    }

    public function test_group_by_single_item(): void
    {
        $bag = $this->utility([['name' => 'Fred', 'role' => 'dev']]);
        $grouped = $bag->groupBy('role');
        $this->assertCount(1, $grouped);
        $this->assertCount(1, $grouped->get('dev'));
    }
    public function test_group_by_string_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor', 'role' => 'dev'],
            ['name' => 'Chris', 'role' => 'design'],
        ]);

        $grouped = $bag->groupBy('role');

        $this->assertCount(2, $grouped);
        $this->assertInstanceOf(Utility::class, $grouped->get('dev'));
        $this->assertCount(2, $grouped->get('dev'));
        $this->assertCount(1, $grouped->get('design'));
    }

    public function test_group_by_with_boolean_keys(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'active' => true],
            ['name' => 'Tor', 'active' => false],
            ['name' => 'Chris', 'active' => true],
        ]);
        $grouped = $bag->groupBy(fn (array $item): string => $item['active'] ? 'active' : 'inactive');
        $this->assertCount(2, $grouped->get('active'));
        $this->assertCount(1, $grouped->get('inactive'));
    }

    public function test_group_by_with_missing_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'role' => 'dev'],
            ['name' => 'Tor'],
            ['name' => 'Chris', 'role' => 'dev'],
        ]);
        $grouped = $bag->groupBy('role');
        $this->assertCount(2, $grouped->get('dev'));
    }

    public function test_group_by_with_null_group_key(): void
    {
        $bag = $this->utility([
            ['name' => 'Fred', 'team' => 'alpha'],
            ['name' => 'Tor', 'team' => null],
            ['name' => 'Chris', 'team' => 'alpha'],
        ]);
        $grouped = $bag->groupBy('team');
        $this->assertCount(2, $grouped->get('alpha'));
        $this->assertCount(1, $grouped->get(''));
    }
}
