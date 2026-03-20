<?php

declare(strict_types=1);

namespace Tests;

use ReflectionClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

final class TransformToBagTest extends BaseBagSuite
{
    /**
     * Check that the transformToBag returns an array of values from a given user input
     */
    public function testExpectedResults(): void
    {
        $utility = $this->utility([]);
        $reflectionClass = new ReflectionClass($utility::class);
        $reflectionMethod = $reflectionClass->getMethod('transformToBag');

        $this->assertEquals([], $reflectionMethod->invokeArgs($utility, [[]]));

        $bagArray = [1, 2, 3];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($utility, [$bagArray]));
        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($utility, [$bagObject]));

        $bagArray = ['hello' => 'world'];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($utility, [$bagArray]));
        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($utility, [$bagObject]));

        $bagConstructorTestCase = new BagConstructorTestCase();
        $classArray = [
            $bagConstructorTestCase,
        ];
        $this->assertEquals($classArray, $reflectionMethod->invokeArgs($utility, [$bagConstructorTestCase]));
    }
}
