#  Methods

The utility implements the core/SPL PHP `ArrayAccess`, `Countable`, `IteratorAggregate` interfaces, so can be used as per
the documentation [here](http://php.net/manual/en/reserved.interfaces.php) and [here](http://php.net/manual/en/spl.interfaces.php).

## add($index, $value): Utility
Add a new value a specified index to the bag

## contains($needles): bool
Alias of [containsAny](##containsany)

## containsAll($needles): bool
Are all the values in the needle bag in the haystack bag

## containsAny($needles): bool
Are any of the needle values in the haystack bag

## count(): int
How many items are in the bag

## exists(): bool
Does a key exist in the bag. Can use dot notation to check deep nested values exist.

## flatten(string $separator = '.')
Flatten a multidimensional array, using the separator to join keys

## get($index, $default = null)
Get a value from a given index or return a default value

## getIterator(): ArrayIterator

## isAssociative(): bool
Is the bag holding associative data

## isIndexed(): bool
Is the bag holding indexed data

## isMultiDimensional(): bool
Is the bag holding multidimensional data

## isSequential(): bool
Is the bag holding sequentially indexed data

## jsonSerialize(): array

## merge($bag): Utility
Merge an array or bag Utility into the current bag

## make($bag): Utility
Create a new instance of the bag utility

## mergeRecursively($bag): Utility
Recursively merge an array or bag Utility into the current bag

## offsetExists($offset): bool

## offsetGet($offset): void

## offsetSet($offset, $value): Utility

## offsetUnset($offset): Utility

## push(...$values): Utility
Push value(s) onto the end of the bag

## remove(string|int $index): Utility
Remove a value from the bag via its index

## removeEmpty(): Utility
Remove all empty values from the bag

## set(string|int $index, mixed $value): Utility
Set an array index with a given value

## toArray(): array
Get the bag as an array

## toKeyValueString(string $glue = ' ', string $keyPrefix = '', string $keyPostfix = '', string $keyJoint = '=', string $valuePrefix = '\'', string $valuePostfix = '\''): string
Implode the bag to show a key=value string

## toObject(): object
Get the bag as an stdClass object

## value()
Get the bags current value
