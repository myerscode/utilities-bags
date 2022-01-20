<?php

namespace Tests\Support;

use Myerscode\Utilities\Bags\DotUtility;
use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\TestCase;

abstract class BaseBagSuite extends TestCase
{
    public function dot($config): DotUtility
    {
        return new DotUtility($config);
    }

    public function utility($config): Utility
    {
        return new Utility($config);
    }
}
