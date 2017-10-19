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
        $this->bag = $this->transformToBag($bag);
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
        $needlesBag = $this->transformToBag($needles);

        return !array_diff($needlesBag, $this->bag);
    }

    /**
     * Are any of the needle values in the haystack bag
     *
     * @param $needles
     *
     * @return bool
     */
    public function containsAny($needles): bool
    {
        $needlesBag = $this->transformToBag($needles);

        return !!array_intersect($needlesBag, $this->bag);
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
     * Is the bag holding associative data
     * key=value opposed to 123=value
     *
     * @return bool
     */
    public function isAssociative(): bool
    {
        return $this->isAssociativeArray($this->bag);
    }

    /**
     * Check if the passed array is associative
     *
     * @param $bag
     *
     * @return bool
     */
    private function isAssociativeArray($bag): bool
    {
        if (sizeof($bag) === 0) {
            return false;
        }

        return array_keys($bag) !== range(0, count($bag) - 1);
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
     * Remove all empty values from the bag
     * An empty value could be null, 0, '', false
     *
     * @return Utility
     */
    public function removeEmpty(): Utility
    {
        $filteredBag = array_filter($this->bag, function ($value) {
            return !empty($value);
        });

        if (!$this->isAssociative()) {
            $filteredBag = array_values($filteredBag);
        }

        return new static($filteredBag);
    }

    /**
     * Implode the the bag to show a key=value string
     *
     * @param string $glue
     * @param string $keyPrefix
     * @param string $keyPostfix
     * @param string $keyJoint
     * @param string $valuePrefix
     * @param string $valuePostfix
     *
     * @return string
     */
    public function toKeyValueString(
        $glue = ' ',
        $keyPrefix = '',
        $keyPostfix = '',
        $keyJoint = '=',
        $valuePrefix = '\'',
        $valuePostfix = '\''
    ) {
        return implode($glue, array_map(
            function ($v, $k) use ($keyPrefix, $keyPostfix, $keyJoint, $valuePrefix, $valuePostfix) {
                return sprintf($keyPrefix . "%s" . $keyPostfix . $keyJoint . $valuePrefix . "%s" . $valuePostfix, $k,
                    $v);
            },
            $this->bag,
            array_keys($this->bag)
        ));
    }

    /**
     * Get the bag as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->bag;
    }

    /**
     * Get the bag as an object
     *
     * @return object
     */
    public function toObject()
    {
        return json_decode(json_encode($this->bag));
    }

    /**
     * Transform the constructor parameter to a usable array for the utility to use
     *
     * @param $bag
     *
     * @return array
     */
    private function transformToBag($bag): array
    {
        if (is_object($bag)) {
            $bag = get_object_vars($bag);
        }

        if (is_array($bag)) {
            $bag = array_map(function ($e) {
                return (is_object($e) || is_array($e)) ? $this->transformToBag($e) : $e;
            }, $bag);
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
