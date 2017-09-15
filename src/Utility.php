<?php

namespace Myerscode\Utilities\Bags;

/**
 * Class Utility
 *
 * @package Myerscode\Utilities\Bags
 */
class Utility implements \Countable, \IteratorAggregate
{

    /**
     * The values of this collection
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
     * Are all the values in the needle bag in the haystack bag
     *
     * @param $needles
     *
     * @return bool
     */
    public function containsAll($needles): bool
    {
        $needlesBag = $this->transformBag($needles);

        return !array_diff($needlesBag, $this->bag);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->bag);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->bag);
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
