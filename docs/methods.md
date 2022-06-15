#  Methods

The utility implements the core/SPL PHP `ArrayAccess`, `Countable`, `IteratorAggregate` interfaces, so can be used as per
the documentation [here](http://php.net/manual/en/reserved.interfaces.php) and [here](http://php.net/manual/en/spl.interfaces.php).

## add($index, $value): Utility
Add a new value a specified index to the bag
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->add(3, 'Chris')->value();
// ['Tor', 'Fred', 'Chris']

$bag->add(1, 'Chris')->value();
// ['Tor', 'Chris']
```

## contains($needles): bool
Alias of [containsAny](##containsany)
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->contains('Chris');
// false

$bag->contains('Tor');
// true
```

## containsAll($needles): bool
Are all the values in the needle bag in the haystack bag
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->containsAll(['Tor']);
// true

$bag->containsAll(['Fred', 'Tor',]);
// true

$bag->containsAll(['Fred', 'Chris',]);
// false
```

## containsAny($needles): bool
Are any of the needle values in the haystack bag
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->containsAny(['Tor', 'Fred']);
// true

$bag->containsAny(['Chris', 'Fred']);
// true

$bag->containsAny(['Chris', 'Jack',]);
// false
```

## count(): int
How many items are in the bag
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->count();
// 2
```

## exists(string|int $index): bool
Does a key exist in the bag. Can use dot notation to check deep nested values exist.
```php 
$bag = new Utility(['Tor', 'number' => 7]);

$bag->exists(1);
// true

$bag->exists('number');
// true

$bag->exists(49);
// false
```

## filter
Remove values from the bag based on a given callback condition. If no condition 
is given, `filter()` will remove falsey values.
```php 
$bag = new Utility([7, 49, 42, 69, false, null, 0]);

$bag->filter(); 
// [7, 49, 42, 69]

$bag = new Utility([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]);

$bag->filter(function ($value) {
 return $value < 5;
}); 
// [1,2,3,4, 9 => 0]
```

## flatten(string $separator = '.')
Flatten a multidimensional array, using the separator to join keys
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'example']]);

$bag->flatten();
// ['0' => 'Tor', '1' => 'Fred', 'foo.bar' => 'example']
```

## get($index, $default = null)
Get a value from a given index or return a default value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->get(1);
// Fred

$bag->get('foo');
// ['bar']

$bag->get('yordle');
// null

$bag->get('yordle', 'Vex');
// 'Vex'
```

## getIterator(): ArrayIterator

## isAssociative(): bool
Is the bag holding associative data
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isAssociative();
// false

$bag = new Utility(['foo' => 'bar', 'hello' => 'world']);

$bag->isAssociative();
// true
```

## isIndexed(): bool
Is the bag holding indexed data
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isAssociative();
// true

$bag = new Utility(['foo' => 'bar', 'hello' => 'world']);

$bag->isAssociative();
// false

$bag = new Utility(['Fred', 'foo' => 'bar', 'hello' => 'world']);

$bag->isAssociative();
// false
```
## isMultiDimensional(): bool
Is the bag holding multidimensional data
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isMultiDimensional();
// false

$bag = new Utility(['foo' => ['bar', => ['hello' => 'world']]]);

$bag->isMultiDimensional();
// true
```

## isSequential(): bool
Is the bag holding sequentially indexed data
```php 
$bag = new Utility([0 => 'Tor', 1 => 'Fred', 2 => 'Chris']);

$bag->isSequential();
// true
$bag = new Utility([0 => 'Tor', 2 => 'Chris']);

$bag->isSequential();
// false
```

## join(string $joinGlue, string $lastGlue = null): string
Join the values of the bag with a given glue string, and additionally
with an optional last glue to create an alternate ending join.
```php 
$bag = new Utility([1,2,3,4,5,6,7,8,9,0]);

$bag->join(',');
// 1, 2, 3, 4, 5, 6, 7, 8, 9, 0

$bag->join(',', ' and ');
// 1, 2, 3, 4, 5, 6, 7, 8, 9 and 0
```

## jsonSerialize(): array

## keys(): string
Return array of root keys from the bag
```php 
$bag = new Utility([7, 48, 'corgi' => 'Rupert', 'ball_chaser' => 'Gerald']);

$bag->keys();
// [0, 1, 'corgi', 'ball_chaser']
```

## merge($bag): Utility
Merge an array or bag Utility into the current bag
```php 
$bag = new Utility([0 => 'Tor', 1 => 'Fred', 2 => 'Chris']);

$bag->isSequential();
// true
$bag = new Utility([0 => 'Tor', 2 => 'Chris']);

$bag->isSequential();
// false
```

## make($bag): Utility
Create a new instance of the bag utility
```php 
$bag = Utility::make(['Tor', 'Fred']);

$bag2 = Utility::make($bag)
```

## merge($bag): Utility
Recursively merge an array or bag Utility into the current bag
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'value']]);

$bag->merge([1 => 'Chris', 'foo' => 'hello world']);
// ['Tor', 'Fred', 'Chris', 'foo' => 'hello world']]
```

## mergeRecursively($bag): Utility
Recursively merge an array or bag Utility into the current bag
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'value']]);

$bag->mergeRecursively([1 => 'Chris', 'foo' => 'hello world']);
// ['Tor', 'Fred', 'Chris', 'foo' => ['hello world', 'bar' => 'value']]
```

## offsetExists($offset): bool

## offsetGet($offset): void

## offsetSet($offset, $value): Utility

## offsetUnset($offset): Utility

## push(...$values): Utility
Push value(s) onto the end of the bag
```php 
$bag = new Utility(['Tor', 'Fred');

$bag->push('Chris');
// ['Tor', 'Fred', 'Chris']

$bag->push('Jack', 'Alex');
// ['Tor', 'Fred', 'Chris', 'Jack', 'Alex']
```

## removeEmpty(): Utility
Remove all empty values from the bag
```php 
$bag = new Utility(['Tor', 'Fred', '', null);

$bag->removeEmpty();
// ['Tor', 'Fred']
```

## remove(string|int $index): Utility
Remove a value from the bag via its index
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->remove(1);
// ['Tor', 'foo' => 'bar']

$bag->remove('foo');
// ['Tor']
```

## resetIndex(): Utility
Resets the sequential index keys of the bag
```php
$bag = new Utility([1 => 7, 7 => 'x', 49 => 7, 77 => 49]);

$bag->resetIndex();
// [0 => 7, 1 => 'x', 2 => 7, 3 => 49];
```

## set(string|int $index, mixed $value): Utility
Set an array index with a given value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->set(1, 'Chris');
// ['Tor', 'Chris' 'foo' => 'bar']

$bag->set('foo', 'Chris');
// ['Tor', 'Fred', 'foo' => 'Chris']
```

## toArray(): array
Get the bag as an array
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->toArray();
// ['Tor', 'Fred', 'foo' => 'bar']
```

## toKeyValueString(string $glue = ' ', string $keyPrefix = '', string $keyPostfix = '', string $keyJoint = '=', string $valuePrefix = '\'', string $valuePostfix = '\''): string
Implode the bag to show a key=value string
```php 
$bag = new Utility(['hello' => 'world', 'foo' => 'bar']);

$bag->toKeyValueString();
// "hello='world' foo='bar'"

$bag->toKeyValueString(', ', '*', '*', '~', '>', '<');
// "*hello*~>world<, *foo*~>bar<"
```

## toObject(): object
Get the bag as an stdClass object

## value()
Get the bags current value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->value();
// ['Tor', 'Fred', 'foo' => 'bar']
```

## values()
Get the bags values (ignoring indexes)
```php 
$bag = new Utility([77 => 49, 'corgi' => 'Gerald', 'owner' => 'Fred']);

$bag->values();
// [49, 'Gerald', 'Fred']
```
