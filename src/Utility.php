<?php

declare(strict_types=1);

namespace Myerscode\Utilities\Bags;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonException;
use JsonSerializable;
use InvalidArgumentException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use stdClass;

class Utility implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * The values of this collection
     */
    protected array $bag;

    public function __construct(mixed $bag = [])
    {
        $this->bag = $this->transformToBag($bag);
    }

    /**
     * Create a new instance of the bag utility
     */
    public static function make(mixed $bag = []): Utility
    {
        return new static($bag);
    }

    /**
     * Add a value to an index if it doesn't exit
     */
    public function add(int|string $index, mixed $value): Utility
    {
        if ($this->get($index) === null) {
            return $this->set($index, $value);
        }

        return $this;
    }

    /**
     * @see containsAny
     */
    public function contains(mixed $needles): bool
    {
        return $this->containsAny($needles);
    }

    /**
     * Are all the values in the needle bag in the haystack bag
     */
    public function containsAll(mixed $needles): bool
    {
        $needlesBag = $this->transformToBag($needles);

        return ! array_diff($needlesBag, $this->bag);
    }

    /**
     * Are any of the needle values in the haystack bag
     */
    public function containsAny(mixed $needles): bool
    {
        $needlesBag = $this->transformToBag($needles);

        return (bool) array_intersect($needlesBag, $this->bag);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->bag);
    }

    /**
     * Pass each value in the bag to a closure so an action can be performed on it
     */
    public function each(callable $eachCallable): Utility
    {
        foreach ($this->value() as $key => $item) {
            $eachCallable($item, $key);
        }

        return $this;
    }

    /**
     * Pass each value in the bag to a closure until a specific value is returned
     */
    public function eachUtil(callable $eachCallable, mixed $stopOn): Utility
    {
        foreach ($this->value() as $key => $item) {
            if ($eachCallable($item, $key) === $stopOn) {
                break;
            }
        }

        return $this;
    }

    /**
     * Return a new bag with all keys except the given ones
     */
    public function except(array|Utility $exceptKeys): Utility
    {
        return new self(array_diff_key($this->bag, array_flip((array) $exceptKeys)));
    }

    /**
     * Check if an index exists in the bag
     */
    public function exists(string|int $index): bool
    {
        if (array_key_exists($index, $this->value())) {
            return true;
        }

        if (count($segments = explode('.', (string) $index)) === 1) {
            return false;
        }

        $array = $this->value();

        foreach ($segments as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Filter the values of the bag with a given callback
     * If no callback filter is provided, all null/falsey values are removed
     */
    public function filter(?callable $filter = null, int $mode = ARRAY_FILTER_USE_BOTH): Utility
    {
        if ($filter !== null) {
            return new static(array_filter($this->bag, $filter, $mode));
        }

        return new static(array_filter($this->bag));
    }

    /**
     * Get the first item in the bag, optionally the first matching a condition
     */
    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        if ($callback === null) {
            return $this->bag === [] ? $default : reset($this->bag);
        }

        foreach ($this->bag as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Flatten a multidimensional array
     */
    public function flatten(string $separator = '.'): Utility
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->toArray()), RecursiveIteratorIterator::SELF_FIRST);
        $path = [];
        $flattened = [];

        foreach ($iterator as $key => $value) {
            $path[$iterator->getDepth()] = $key;
            if (! is_array($value)) {
                $flattened[implode($separator, array_slice($path, 0, $iterator->getDepth() + 1))] = $value;
            }
        }

        return static::make($flattened);
    }

    /**
     * Get a value from a given index or return a default value
     */
    public function get(int|string $index, mixed $default = null): mixed
    {
        if ($this->exists($index)) {
            if (is_int($index) || count(explode('.', $index)) === 1) {
                return $this->bag[$index];
            }

            return $this->dotGet($index, $default);
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->bag);
    }

    /**
     * Group the bag items by a given key or callback
     */
    public function groupBy(string|callable $keyOrCallback): Utility
    {
        if (is_string($keyOrCallback)) {
            $key = $keyOrCallback;
            $callback = fn (mixed $item): mixed => is_array($item) ? ($item[$key] ?? null) : null;
        } else {
            $callback = $keyOrCallback;
        }

        $groups = [];

        foreach ($this->bag as $key => $value) {
            $groupKey = $callback($value, $key);
            $groups[$groupKey][] = $value;
        }

        return new static(array_map(fn (array $group): Utility => new static($group), $groups));
    }

    /**
     * Is the bag holding associative data
     * key=value opposed to 123=value
     */
    public function isAssociative(): bool
    {
        if ($this->bag === []) {
            return false;
        }

        return array_keys($this->bag) !== range(0, count($this->bag) - 1);
    }

    /**
     * Check if the bag is empty
     */
    public function isEmpty(): bool
    {
        return $this->bag === [];
    }

    /**
     * Is the bag a indexed array
     * e.g. $arr[0], $arr[7], $arr[49]
     */
    public function isIndexed(): bool
    {
        return array_is_list($this->bag) || array_filter(array_keys($this->bag), is_int(...)) === array_keys($this->bag);
    }

    /**
     * Is the bag holding multidimensional data
     */
    public function isMultiDimensional(): bool
    {
        if ($this->bag === []) {
            return false;
        }

        return count($this->bag) !== count($this->bag, COUNT_RECURSIVE);
    }

    /**
     * Check if the bag is not empty
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Is the bag a sequential array
     * e.g. $arr[0], $arr[1], $arr[2]
     */
    public function isSequential(): bool
    {
        return array_is_list($this->bag);
    }

    /**
     * Join the values of an array
     */
    public function join(string $joinGlue, ?string $lastGlue = null): string
    {
        $values = $this->values();

        if ($lastGlue === null) {
            return implode($joinGlue, $values);
        }

        return implode($joinGlue, array_slice($values, 0, $this->count() - 1)).$lastGlue.array_slice($values, -1, 1)[0];
    }

    /**
     * Return items for JSON serialization
     */
    public function jsonSerialize(): array
    {
        return $this->bag;
    }

    /**
     * Return array of root keys from the bag
     */
    public function keys(): array
    {
        return array_keys($this->bag);
    }

    /**
     * Get the last item in the bag, optionally the last matching a condition
     */
    public function last(?callable $callback = null, mixed $default = null): mixed
    {
        if ($callback === null) {
            return $this->bag === [] ? $default : end($this->bag);
        }

        $result = $default;

        foreach ($this->bag as $key => $value) {
            if ($callback($value, $key)) {
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Create new bag containing the results of applying the callback to each value in the current bag
     */
    public function map(callable $mapper): Utility
    {
        $keys = array_keys($this->bag);

        $items = array_map($mapper, $this->bag, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Remap the values of the bag with new index keys
     *
     * The mapper should return an key/value pair array with a single value
     */
    public function mapKeys(callable $mapper): Utility
    {
        $mapped = array_reduce(array_map($mapper, array_keys($this->bag), $this->bag), function (array $newBag, array $mappedValue): array {
            if (count($mappedValue) > 1) {
                throw new InvalidArgumentException('Mapped value must be a single key/value pair.');
            }

            return $newBag + $mappedValue;
        }, []);

        return new static($mapped);
    }

    /**
     * Merge an array or bag Utility into the current bag
     */
    public function merge(array|stdClass|Utility $bag): Utility
    {
        if ($bag instanceof self) {
            return new static(array_merge($this->bag, $bag->toArray()));
        }

        return new static(array_merge($this->bag, new static($bag)->toArray()));
    }

    /**
     * Recursively merge an array or bag Utility into the current bag
     */
    public function mergeRecursively(mixed $bag): Utility
    {
        if ($bag instanceof self) {
            return new static(array_merge_recursive($this->bag, $bag->toArray()));
        }

        return new static(array_merge_recursive($this->bag, new static($bag)->toArray()));
    }

    /**
     * Get the maximum value in the bag, optionally by key or callback
     */
    public function max(string|callable|null $callback = null): mixed
    {
        if ($this->bag === []) {
            return null;
        }

        if ($callback === null) {
            return max($this->bag);
        }

        if (is_string($callback)) {
            $key = $callback;
            $callback = fn (mixed $item): mixed => is_array($item) ? ($item[$key] ?? null) : null;
        }

        return max(array_map($callback, $this->bag));
    }

    /**
     * Get the minimum value in the bag, optionally by key or callback
     */
    public function min(string|callable|null $callback = null): mixed
    {
        if ($this->bag === []) {
            return null;
        }

        if ($callback === null) {
            return min($this->bag);
        }

        if (is_string($callback)) {
            $key = $callback;
            $callback = fn (mixed $item): mixed => is_array($item) ? ($item[$key] ?? null) : null;
        }

        return min(array_map($callback, $this->bag));
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->exists($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set a value at a given offset.
     * NOTE: To comply with ArrayAccess interface this method mutates itself and doesn't return a new utility
     *
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        self::__construct($this->set($offset, $value));
    }

    /**
     * Unset a value at a given offset.
     * NOTE: To comply with ArrayAccess interface this method mutates itself and doesn't return a new utility
     *
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        self::__construct($this->remove($offset));
    }

    /**
     *  Return a new bag with only the given ones
     */
    public function only(array|Utility $onlyKeys): Utility
    {
        return new self(array_intersect_key($this->bag, array_flip((array) $onlyKeys)));
    }

    /**
     * Extract a single column of values from a multi-dimensional bag
     */
    public function pluck(string $valuePath, ?string $keyPath = null): Utility
    {
        $results = [];

        foreach ($this->bag as $item) {
            $item = is_array($item) ? $item : (array) $item;
            $value = $item[$valuePath] ?? null;

            if ($keyPath !== null) {
                $results[$item[$keyPath] ?? null] = $value;
            } else {
                $results[] = $value;
            }
        }

        return new static($results);
    }

    /**
     * Push a value onto the end of the bag
     */
    public function push(mixed ...$values): Utility
    {
        $newBag = $this->toArray();

        foreach ($values as $value) {
            $newBag[] = $value;
        }

        return new self($newBag);
    }

    /**
     * Reduce the bag to a single value using a callback
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return array_reduce($this->bag, $callback, $initial);
    }

    /**
     * Remove a value from the bag via its index
     */
    public function remove(string|int $index): Utility
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
     */
    public function removeEmpty(): Utility
    {
        $filteredBag = array_filter($this->bag, fn ($value): bool => ! empty($value));

        if (! $this->isAssociative()) {
            $filteredBag = array_values($filteredBag);
        }

        return new static($filteredBag);
    }

    /**
     * Resets the sequential index keys of the bag
     */
    public function resetIndex(): Utility
    {
        if ($this->isIndexed() || $this->isSequential()) {
            return new static(array_values($this->bag));
        }

        $assocKeys = $this->filter(fn ($value, $key): bool => ! is_int($key))->keys();
        $indexedKeys = $this->filter(fn ($value, $key): bool => is_int($key))->keys();

        $assocValues = $this->filter(fn ($key): bool => in_array($key, $assocKeys), ARRAY_FILTER_USE_KEY)->value();
        $indexedValues = $this->filter(fn ($key): bool => in_array($key, $indexedKeys), ARRAY_FILTER_USE_KEY)->values();

        return new static($assocValues + $indexedValues);
    }

    /**
     * Set an array index with a given value
     */
    public function set(string|int $index, mixed $value): Utility
    {
        $newBag = $this->toArray();

        $newBag[$index] = $value;

        return new self($newBag);
    }

    /**
     * Sort the bag values, optionally with a custom comparison callback
     */
    public function sort(?callable $callback = null): Utility
    {
        $bag = $this->bag;

        if ($callback !== null) {
            uasort($bag, $callback);
        } else {
            asort($bag);
        }

        return new static($bag);
    }

    /**
     * Sort the bag by a given key or callback
     */
    public function sortBy(string|callable $keyOrCallback, bool $descending = false): Utility
    {
        if (is_string($keyOrCallback)) {
            $key = $keyOrCallback;
            $callback = fn (mixed $item): mixed => is_array($item) ? ($item[$key] ?? null) : null;
        } else {
            $callback = $keyOrCallback;
        }

        $bag = $this->bag;

        uasort($bag, function (mixed $a, mixed $b) use ($callback, $descending): int {
            $valueA = $callback($a);
            $valueB = $callback($b);

            return $descending ? ($valueB <=> $valueA) : ($valueA <=> $valueB);
        });

        return new static($bag);
    }

    /**
     * Get the sum of values in the bag, optionally by key or callback
     */
    public function sum(string|callable|null $callback = null): int|float
    {
        if ($callback === null) {
            return array_sum($this->bag);
        }

        if (is_string($callback)) {
            $key = $callback;
            $callback = fn (mixed $item): mixed => is_array($item) ? ($item[$key] ?? 0) : 0;
        }

        return array_sum(array_map($callback, $this->bag));
    }

    /**
     * Get the bag as an array
     */
    public function toArray(): array
    {
        return $this->bag;
    }

    /**
     * Implode the bag to show a key=value string
     */
    public function toKeyValueString(
        string $glue = ' ',
        string $keyPrefix = '',
        string $keyPostfix = '',
        string $keyJoint = '=',
        string $valuePrefix = "'",
        string $valuePostfix = "'"
    ): string {
        return implode(
            $glue,
            array_map(
                fn ($v, string $k): string => sprintf(
                    $keyPrefix.'%s'.$keyPostfix.$keyJoint.$valuePrefix.'%s'.$valuePostfix,
                    $k,
                    $v
                ),
                $this->bag,
                array_keys($this->bag)
            )
        );
    }

    /**
     * Get the bag as an stdClass object
     *
     * @throws JsonException
     */
    public function toObject(): stdClass
    {
        return json_decode(json_encode((object) $this->bag, JSON_THROW_ON_ERROR), null, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Return a new bag with only unique values
     */
    public function unique(?callable $callback = null): Utility
    {
        if ($callback === null) {
            return new static(array_unique($this->bag, SORT_REGULAR));
        }

        $seen = [];
        $result = [];

        foreach ($this->bag as $key => $value) {
            $computed = $callback($value, $key);

            if (! in_array($computed, $seen, true)) {
                $seen[] = $computed;
                $result[$key] = $value;
            }
        }

        return new static($result);
    }

    /**
     * Get the bags current value
     */
    public function value(): array
    {
        return $this->bag;
    }

    /**
     * Get the values of the array (ignoring any indexes)
     */
    public function values(): array
    {
        return array_values($this->value());
    }

    protected function dotGet(string $index, mixed $default = null): mixed
    {
        $value = $this->value();
        foreach (explode('.', $index) as $segment) {
            if (isset($value[$segment])) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    /**
     * Transform the constructor parameter to a usable array for the utility to use
     */
    protected function transformToBag(mixed $bag): array
    {
        if ($bag instanceof self) {
            $bag = $bag->value();
        }

        if ($bag instanceof stdClass) {
            $bag = get_object_vars($bag);
        }

        $bag = is_array($bag) ? $bag : [$bag];

        return array_map(fn ($e): mixed => (($e instanceof stdClass) || is_array($e)) ? $this->transformToBag($e) : $e, $bag);
    }
}
