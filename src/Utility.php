<?php

namespace Myerscode\Utilities\Bags;

/**
 * Class Utility
 *
 * @package Myerscode\Utilities\Bags
 */
class Utility
{

    /**
     * The value this model is representing
     *
     * @var array
     */
    private $bag;

    /**
     * Utility constructor.
     *
     * @param $bag
     */
    public function __construct($bag)
    {
        $this->bag = $this->transformBag($bag);
    }

    /**
     * Create a new instance of the bag utility
     *
     * @param $bag
     *
     * @return $this
     */
    public static function make($bag): Utility
    {
        return new static($bag);
    }

    /**
     * Transform the constructor parameter to a usable array for the utility to use
     *
     * @param $bag
     *
     * @return array
     */
    private function transformBag($bag)
    {
        if (is_object($bag)) {
            $bag = get_object_vars($bag);
        }

        if (is_array($bag)) {
            return array_map(__METHOD__, $bag);
        }

        return $bag;
    }

    /**
     * Get the bags current value
     *
     * @return array
     */
    public function value()
    {
        return $this->bag;
    }
}
