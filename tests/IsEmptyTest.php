<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class IsEmptyTest extends BaseBagSuite
{
    public function testIsEmptyReturnsFalseForNonEmptyBag(): void
    {
        $this->assertFalse($this->utility([1])->isEmpty());
    }

    public function testIsEmptyReturnsTrueForEmptyBag(): void
    {
        $this->assertTrue($this->utility([])->isEmpty());
    }

    public function testIsEmptyWithFalseyValuesIsNotEmpty(): void
    {
        $this->assertFalse($this->utility([null])->isEmpty());
        $this->assertFalse($this->utility([false])->isEmpty());
        $this->assertFalse($this->utility([0])->isEmpty());
        $this->assertFalse($this->utility([''])->isEmpty());
    }

    public function testIsNotEmptyReturnsFalseForEmptyBag(): void
    {
        $this->assertFalse($this->utility([])->isNotEmpty());
    }

    public function testIsNotEmptyReturnsTrueForNonEmptyBag(): void
    {
        $this->assertTrue($this->utility([1])->isNotEmpty());
    }

    public function testIsNotEmptyWithNestedEmptyArray(): void
    {
        $this->assertTrue($this->utility([[]])->isNotEmpty());
    }
}
