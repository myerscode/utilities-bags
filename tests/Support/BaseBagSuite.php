<?php

namespace Tests\Support;

use Myerscode\Utilities\Bags\Utility;
use PHPUnit\Framework\TestCase;

abstract class BaseBagSuite extends TestCase
{
    /**
     * Utility class name
     *
     * @var string $utility
     */
    public $utility = Utility::class;

    /**
     * {@inheritdoc}
     *
     * @param $config
     * @return Utility
     */
    public function utility($config)
    {
        return new Utility($config);
    }
}
