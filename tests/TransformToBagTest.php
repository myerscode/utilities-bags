<?php

namespace Tests;

use ReflectionClass;
use Tests\Support\BagConstructorTestCase;
use Tests\Support\BaseBagSuite;

/**
 * @coversDefaultClass Myerscode\Utilities\Bags\Utility
 */
class TransformToBagTest extends BaseBagSuite
{

    /**
     * Check that the transformToBag returns an array of values from a given user input
     *
     * @covers ::transformToBag
     */
    public function testExpectedResults()
    {
        $class = $this->utility([]);
        $reflectionClass = new ReflectionClass(get_class($class));
        $method = $reflectionClass->getMethod('transformToBag');
        $method->setAccessible(true);

        $this->assertEquals([], $method->invokeArgs($class, [[]]));

        $bagArray = [1, 2, 3];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $method->invokeArgs($class, [$bagArray]));
        $this->assertEquals($bagArray, $method->invokeArgs($class, [$bagObject]));

        $bagArray = ['hello' => 'world'];
        $bagObject = json_decode(json_encode($bagArray), null, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($bagArray, $method->invokeArgs($class, [$bagArray]));
        $this->assertEquals($bagArray, $method->invokeArgs($class, [$bagObject]));

        $bagConstructorTestCase = new BagConstructorTestCase();
        $classArray = [
            $bagConstructorTestCase,
        ];
        $this->assertEquals($classArray, $method->invokeArgs($class, [$bagConstructorTestCase]));
    }
}
