<?php

declare(strict_types=1);

namespace Tests;

use Myerscode\Utilities\Bags\Utility;
use Tests\Support\BaseBagSuite;

use function Myerscode\Utilities\Bags\bag;

final class HelperTest extends BaseBagSuite
{
    public function testHelperFunction(): void
    {
        $this->assertInstanceOf(Utility::class, bag());
    }
}
