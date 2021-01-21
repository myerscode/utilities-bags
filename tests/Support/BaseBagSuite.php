<?php

namespace Tests\Support;

use Myerscode\Utilities\Bags\DotUtility;
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
     * DotUtility class name
     *
     * @var string $dotUtility
     */
    public $dotUtility = DotUtility::class;

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

    /**
     * Get a new instance of the DotUtility class
     *
     * @param $config
     * @return DotUtility
     */
    public function dot($config)
    {
        return new DotUtility($config);
    }
}
