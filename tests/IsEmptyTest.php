<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class IsEmptyTest extends BaseBagSuite
{
    public function test_is_empty_returns_false_for_non_empty_bag(): void
    {
        $this->assertFalse($this->utility([1])->isEmpty());
    }
    public function test_is_empty_returns_true_for_empty_bag(): void
    {
        $this->assertTrue($this->utility([])->isEmpty());
    }

    public function test_is_empty_with_falsey_values_is_not_empty(): void
    {
        $this->assertFalse($this->utility([null])->isEmpty());
        $this->assertFalse($this->utility([false])->isEmpty());
        $this->assertFalse($this->utility([0])->isEmpty());
        $this->assertFalse($this->utility([''])->isEmpty());
    }

    public function test_is_not_empty_returns_false_for_empty_bag(): void
    {
        $this->assertFalse($this->utility([])->isNotEmpty());
    }

    public function test_is_not_empty_returns_true_for_non_empty_bag(): void
    {
        $this->assertTrue($this->utility([1])->isNotEmpty());
    }

    public function test_is_not_empty_with_nested_empty_array(): void
    {
        $this->assertTrue($this->utility([[]])->isNotEmpty());
    }
}
