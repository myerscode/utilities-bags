<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\DotUtility;
use stdClass;
use Tests\Support\BaseBagSuite;

final class ReplaceRecursivelyTest extends BaseBagSuite
{
    public function testDotUtilityExpandsDottedKeys(): void
    {
        $bag = $this->dot(['Rupert' => ['age' => 30, 'town' => 'Leeds']]);

        $this->assertSame(
            ['Rupert' => ['age' => 31, 'town' => 'Leeds']],
            $bag->replaceRecursively(['Rupert.age' => 31])->value()
        );
    }

    public function testDotUtilityReplacesWithBag(): void
    {
        $bag = $this->dot(['Rupert' => ['age' => 30]]);

        $this->assertSame(
            ['Rupert' => ['age' => 32]],
            $bag->replaceRecursively(new DotUtility(['Rupert.age' => 32]))->value()
        );
    }

    public function testDotUtilityReturnsDotUtility(): void
    {
        $this->assertInstanceOf(DotUtility::class, $this->dot(['Rupert'])->replaceRecursively(['Gerald']));
    }

    public function testReplacesFromBag(): void
    {
        $bag = $this->utility(['Rupert' => 'Leeds']);

        $this->assertSame(['Rupert' => 'York'], $bag->replaceRecursively($this->utility(['Rupert' => 'York']))->value());
    }

    public function testReplacesFromObject(): void
    {
        $object = new stdClass();
        $object->Rupert = 'York';

        $this->assertSame(['Rupert' => 'York'], $this->utility(['Rupert' => 'Leeds'])->replaceRecursively($object)->value());
    }

    public function testReplacesIndexedValuesByPosition(): void
    {
        $bag = $this->utility(['Rupert', 'Gerald', 'Arthur']);

        $this->assertSame(['Rupert', 'Arthur', 'Arthur'], $bag->replaceRecursively([1 => 'Arthur'])->value());
    }

    public function testReplacesNestedValuesKeepingOthers(): void
    {
        $bag = $this->utility(['Rupert' => ['age' => 30, 'town' => 'Leeds'], 'Gerald' => 'x']);

        $this->assertSame(
            ['Rupert' => ['age' => 31, 'town' => 'Leeds'], 'Gerald' => 'y'],
            $bag->replaceRecursively(['Rupert' => ['age' => 31], 'Gerald' => 'y'])->value()
        );
    }

    public function testReturnsNewInstance(): void
    {
        $bag = $this->utility(['Rupert' => 'Leeds']);
        $bag->replaceRecursively(['Rupert' => 'York']);

        $this->assertSame(['Rupert' => 'Leeds'], $bag->value());
    }
}
