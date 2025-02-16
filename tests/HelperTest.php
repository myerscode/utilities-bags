<?php

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

use function Myerscode\Utilities\Bags\bag;

class HelperTest extends BaseBagSuite
{

    function test_helper_function()
    {
        $this->assertInstanceOf(Utility::class, bag());
    }
}