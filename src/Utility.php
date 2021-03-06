<?php

namespace Myerscode\Utilities\Bags;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * Class Utility
 *
 * @package Myerscode\Utilities\Bags
 */
class Utility implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{

    /**
     * The values of this collection
     *
     * @var array
     */
    protected $bag;

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
     * Add a value to an index if it doesn't exit
     *
     * @param $value
     * @param $index
     *
     * @return Utility
     */
    public function add($index, $value): Utility
    {
        if (is_null($this->get($index))) {
            return $this->set($index, $value);
        }

        return $this;
    }

    /**
     * Alias of contains any
     *
     * @param $needles
     *
     * @return bool
     */
    public function contains($needles): bool
    {
        return $this->containsAny($needles);
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
     * Check if an index exists in the bag
     *
     * @param $index
     *
     * @return bool
     */
    public function exists($index): bool
    {
        return isset($this->bag[$index]);
    }

    /**
     * Get a value from a given index or return a default value
     *
     * @param $index
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($index, $default = null)
    {
        if ($this->exists($index)) {
            return $this->bag[$index];
        }

        return $default;
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
        if (count($this->bag) === 0) {
            return false;
        }

        return array_keys($this->bag) !== range(0, count($this->bag) - 1);
    }

    /**
     * Is the bag a indexed array
     * e.g. $arr[0], $arr[7], $arr[49]
     *
     * @return bool
     */
    public function isIndexed(): bool
    {
        $arr = $this->bag;

        for (reset($arr); is_int(key($arr)); next($arr)) {
            ;
        }
        return is_null(key($arr));
    }

    /**
     * Is the bag holding multidimensional data
     *
     * @return bool
     */
    public function isMultiDimensional(): bool
    {
        if (sizeof($this->bag) === 0) {
            return false;
        }

        return count($this->bag) !== count($this->bag, COUNT_RECURSIVE);
    }

    /**
     * Is the bag a sequential array
     * e.g. $arr[0], $arr[1], $arr[2]
     *
     * @return bool
     */
    function isSequential()
    {
        $rangeLength = count($this->bag) - 1;

        $range = ($rangeLength >= 0) ? range(0, ($rangeLength >= 0) ? $rangeLength : 0) : [];

        return empty(array_diff(array_keys($this->bag), $range));
    }

    /**
     * Return items for JSON serialization
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->bag;
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
     * Merge a array or bag Utility into the array
     *
     * @param $bag
     *
     * @return Utility
     */
    public function merge($bag): Utility
    {
        if ($bag instanceof self) {
            return new static(array_merge($this->bag, $bag->toArray()));
        }

        return new static(array_merge($this->bag, (new static($bag))->toArray()));
    }

    /**
     * Recursively Merge a array or bag Utility into the array
     *
     * @param $bag
     *
     * @return Utility
     */
    public function mergeRecursively($bag): Utility
    {
        if ($bag instanceof self) {
            return new static(array_merge_recursive($this->bag, $bag->toArray()));
        }

        return new static(array_merge_recursive($this->bag, (new static($bag))->toArray()));
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->exists($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): Utility
    {
        return $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): Utility
    {
        return $this->remove($offset);
    }

    /**
     * Push a value onto the end of the bag
     *
     * @param $values
     *
     * @return Utility
     */
    public function push(...$values): Utility
    {
        $newBag = $this->toArray();

        foreach ($values as $value) {
            array_push($newBag, $value);
        }

        return new self($newBag);
    }

    /**
     * Remove an value from the bag via its index
     *
     * @param $index
     *
     * @return Utility
     */
    public function remove($index): Utility
    {
        if ($this->exists($index)) {
            $newBag = $this->toArray();
            unset($newBag[$index]);
            return new self($newBag);
        }

        return $this;
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
     * Set an array index with a given value
     *
     * @param $value
     * @param $index
     *
     * @return Utility
     */
    public function set($index, $value): Utility
    {
        $newBag = $this->toArray();

        $newBag[$index] = $value;

        return new self($newBag);
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
    )
    {
        return implode($glue, array_map(
            function ($v, $k) use ($keyPrefix, $keyPostfix, $keyJoint, $valuePrefix, $valuePostfix) {
                return sprintf(
                    $keyPrefix . "%s" . $keyPostfix . $keyJoint . $valuePrefix . "%s" . $valuePostfix,
                    $k,
                    $v
                );
            },
            $this->bag,
            array_keys($this->bag)
        ));
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
    protected function transformToBag($bag): array
    {
        if (is_object($bag) && $bag instanceof \stdClass) {
            $bag = get_object_vars($bag);
        }

        $bag = is_array($bag) ? $bag : [$bag];

        $bag = array_map(function ($e) {
            return ((is_object($e) && $e instanceof \stdClass) || is_array($e)) ? $this->transformToBag($e) : $e;
        }, $bag);

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
