<?php

namespace Tests;

use ReflectionClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

class TransformToBagTest extends BaseBagSuite
{
    /**
     * Check that the transformToBag returns an array of values from a given user input
     */
    public function test_expected_results(): void
    {
        $class = $this->utility([]);
        $reflectionClass = new ReflectionClass($class::class);
        $reflectionMethod = $reflectionClass->getMethod('transformToBag');
        $reflectionMethod->setAccessible(true);

        $this->assertEquals([], $reflectionMethod->invokeArgs($class, [[]]));

        $bagArray = [1, 2, 3];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($class, [$bagArray]));
        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($class, [$bagObject]));

        $bagArray = ['hello' => 'world'];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($class, [$bagArray]));
        $this->assertEquals($bagArray, $reflectionMethod->invokeArgs($class, [$bagObject]));

        $bagConstructorTestCase = new BagConstructorTestCase;
        $classArray = [
            $bagConstructorTestCase,
        ];
        $this->assertEquals($classArray, $reflectionMethod->invokeArgs($class, [$bagConstructorTestCase]));
    }
}
