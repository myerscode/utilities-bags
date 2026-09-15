#  Methods

The utility implements the core/SPL PHP `ArrayAccess`, `Countable`, `IteratorAggregate` interfaces, so can be used as per
the documentation [here](http://php.net/manual/en/reserved.interfaces.php) and [here](http://php.net/manual/en/spl.interfaces.php).

## Available Methods

| | | | |
|---|---|---|---|
| [add](#addindex-value-utility) | [get](#getindex-default--null) | [max](#maxstringcallablenull-callback--null-mixed) | [removeEmpty](#removeempty-utility) |
| [average](#averagestringcallablenull-callback--null-intfloatnull) | [getIterator](#getiterator-arrayiterator) | [merge](#mergebag-utility) | [resetIndex](#resetindex-utility) |
| [avg](#avgstringcallablenull-callback--null-intfloatnull) | [groupBy](#groupbystringcallable-keyorcallback-utility) | [mergeRecursively](#mergerecursivelybag-utility) | [reverse](#reversebool-preservekeys--false-utility) |
| [chunk](#chunkint-size-utility) | [isAssociative](#isassociative-bool) | [min](#minstringcallablenull-callback--null-mixed) | [set](#setstringint-index-mixed-value-utility) |
| [contains](#containsneedles-bool) | [isEmpty](#isempty-bool) | [offsetExists](#offsetexistsoffset-bool) | [skip](#skipint-count-utility) |
| [containsAll](#containsallneedles-bool) | [isIndexed](#isindexed-bool) | [offsetGet](#offsetgetoffset-mixed) | [slice](#sliceint-offset-int-length--null-utility) |
| [containsAny](#containsanyneedles-bool) | [isMultiDimensional](#ismultidimensional-bool) | [offsetSet](#offsetsetoffset-value-void) | [sort](#sortcallable-callback--null-utility) |
| [count](#count-int) | [isNotEmpty](#isnotempty-bool) | [offsetUnset](#offsetunsetoffset-void) | [sortBy](#sortbystringcallable-keyorcallback-bool-descending--false-utility) |
| [each](#eachcallable-eachcallable-utility) | [isSequential](#issequential-bool) | [only](#onlyarrayutility-onlykeys-utility) | [sum](#sumstringcallablenull-callback--null-intfloat) |
| [eachUtil](#eachutilcallable-eachcallable-mixed-stopon-utility) | [join](#joinstring-joinglue-string-lastglue--null-string) | [pipe](#pipecallable-callback-mixed) | [take](#takeint-limit-utility) |
| [except](#exceptarrayutility-exceptkeys-utility) | [jsonSerialize](#jsonserialize-array) | [pluck](#pluckstring-valuepath-string-keypath--null-utility) | [toArray](#toarray-array) |
| [exists](#existsstringint-index-bool) | [keys](#keys-array) | [prepend](#prependvalue-key--null-utility) | [toKeyValueString](#tokeyvaluestringstring-glue----string-keyprefix---string-keypostfix---string-keyjoint--string-valueprefix---string-valuepostfix---string) |
| [filter](#filter) | [last](#lastcallable-callback--null-mixed-default--null-mixed) | [push](#pushvalues-utility) | [toObject](#toobject-object) |
| [first](#firstcallable-callback--null-mixed-default--null-mixed) | [make](#makebag-utility) | [reduce](#reducecallable-callback-mixed-initial--null-mixed) | [unique](#uniquecallable-callback--null-utility) |
| [flatten](#flattenstring-separator---) | [map](#mapcallable-mapper-utility) | [reject](#rejectcallable-callback-int-mode--array_filter_use_both-utility) | [value](#value) |
| [flip](#flip-utility) | [mapKeys](#mapkeyscallable-mapper-utility) | [remove](#removestringint-index-utility) | [values](#values) |

---

### add($index, $value): Utility
> Returns `Utility`


Add a value to an index if it doesn't already exist
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->add(3, 'Chris')->value();
// ['Tor', 'Fred', 'Chris']

$bag->add(0, 'Chris')->value();
// ['Tor', 'Fred'] — index 0 already exists, so it's unchanged
```

### average(string|callable|null $callback = null): int|float|null
> Returns `int|float|null`

Alias of [avg](#avgstringcallablenull-callback--null-intfloatnull)
```php
$bag = new Utility([1, 2, 3]);

$bag->average();
// 2
```

### avg(string|callable|null $callback = null): int|float|null
> Returns `int|float|null`

Get the average of the values in the bag. Optionally pass a key or callback to average a column of a multidimensional bag. Returns `null` for an empty bag. Like PHP division, a whole result is returned as an `int` and a fractional result as a `float`.
```php
$bag = new Utility([1, 2, 3]);

$bag->avg();
// 2

$bag = new Utility([1, 2, 3, 4]);

$bag->avg();
// 2.5

$bag = new Utility([
    ['score' => 10],
    ['score' => 20],
    ['score' => 60],
]);

$bag->avg('score');
// 30

$bag->avg(fn ($item) => $item['score']);
// 30
```

### chunk(int $size): Utility
> Returns `Utility`

Split the bag into chunks of the given size
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->chunk(2);
// [Utility([1, 2]), Utility([3, 4]), Utility([5])]
```

### contains($needles): bool
> Returns `bool`

Alias of [containsAny](##containsany)
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->contains('Chris');
// false

$bag->contains('Tor');
// true
```

### containsAll($needles): bool
> Returns `bool`

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

### containsAny($needles): bool
> Returns `bool`

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

### count(): int
> Returns `int`

How many items are in the bag
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->count();
// 2
```

### each(callable $eachCallable): Utility
> Returns `Utility`

Pass each value in the bag to a closure so an action can be performed on it
```php
$bag = new Utility(['Tor', 'Fred']);

$bag->each(function ($value, $key) {
    echo $value;
});

// Tor
// Fred
```

### eachUtil(callable $eachCallable, mixed $stopOn): Utility
> Returns `Utility`

Pass each value in the bag to a closure until the callback returns the stop value
```php
$bag = new Utility(['Tor', 'Gerald', 'Rupert', 'Chris', 'Fred']);

$bag->eachUtil(function ($value, $key) {
    echo $value;
    return $value;
}, 'Rupert');

// Tor
// Gerald
// Rupert
```

### except(array|Utility $exceptKeys): Utility
> Returns `Utility`

Make a new bag excluding the given keys
```php 
$bag = new Utility([
            'foo' => 'bar',
            'hello' => 'world',
            'fluffy' => 'corgi',
            'Rupert',
            'Gerald',
        ]);
        
$bag->except(['foo', 'hello',]);
// ['fluffy' => 'corgi', 'Rupert', 'Gerald']]
```

### exists(string|int $index): bool
> Returns `bool`

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

### filter
> Returns `Utility`

Remove values from the bag based on a given callback condition. If no condition 
is given, `filter()` will remove falsey values.
```php 
$bag = new Utility([7, 49, 42, 69, false, null, 0]);

$bag->filter(); 
// [7, 49, 42, 69]

$bag = new Utility([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]);

$bag->filter(function ($value, $key) {
 return $value < 5;
}); 
// [0 => 1, 1 => 2, 2 => 3, 3 => 4, 9 => 0]
```

### first(?callable $callback = null, mixed $default = null): mixed
> Returns `mixed`

Get the first item in the bag, optionally the first matching a condition
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->first();
// 1

$bag->first(fn ($value) => $value > 3);
// 4

$bag->first(fn ($value) => $value > 10, 'fallback');
// 'fallback'
```

### flatten(string $separator = '.')
> Returns `Utility`

Flatten a multidimensional array, using the separator to join keys
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'example']]);

$bag->flatten();
// ['0' => 'Tor', '1' => 'Fred', 'foo.bar' => 'example']
```

### flip(): Utility
> Returns `Utility`

Swap the keys and values of the bag. When values are duplicated, the last key wins.
```php
$bag = new Utility(['a' => 'x', 'b' => 'y']);

$bag->flip()->toArray();
// ['x' => 'a', 'y' => 'b']

$bag = new Utility(['foo', 'bar']);

$bag->flip()->toArray();
// ['foo' => 0, 'bar' => 1]
```

### get($index, $default = null)
> Returns `mixed`

Get a value from a given index or return a default value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->get(1);
// Fred

$bag->get('foo');
// 'bar'

$bag->get('yordle');
// null

$bag->get('yordle', 'Vex');
// 'Vex'
```

### getIterator(): ArrayIterator
> Returns `ArrayIterator`

### groupBy(string|callable $keyOrCallback): Utility
> Returns `Utility`

Group the bag items by a given key or callback
```php
$bag = new Utility([
    ['name' => 'Fred', 'role' => 'dev'],
    ['name' => 'Tor', 'role' => 'dev'],
    ['name' => 'Chris', 'role' => 'design'],
]);

$bag->groupBy('role');
// ['dev' => Utility([...]), 'design' => Utility([...])]

$bag = new Utility([1, 2, 3, 4, 5, 6]);

$bag->groupBy(fn ($value) => $value % 2 === 0 ? 'even' : 'odd');
// ['odd' => Utility([1, 3, 5]), 'even' => Utility([2, 4, 6])]
```

### isAssociative(): bool
> Returns `bool`

Is the bag holding associative data
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isAssociative();
// false

$bag = new Utility(['foo' => 'bar', 'hello' => 'world']);

$bag->isAssociative();
// true
```

### isEmpty(): bool
> Returns `bool`

Check if the bag is empty
```php
$bag = new Utility([]);

$bag->isEmpty();
// true

$bag = new Utility([1]);

$bag->isEmpty();
// false
```

### isIndexed(): bool
> Returns `bool`

Is the bag holding indexed data (all keys are integers)
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isIndexed();
// true

$bag = new Utility(['foo' => 'bar', 'hello' => 'world']);

$bag->isIndexed();
// false

$bag = new Utility(['Fred', 'foo' => 'bar', 'hello' => 'world']);

$bag->isIndexed();
// false
```

### isMultiDimensional(): bool
> Returns `bool`

Is the bag holding multidimensional data
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->isMultiDimensional();
// false

$bag = new Utility(['foo' => ['bar' => ['hello' => 'world']]]);

$bag->isMultiDimensional();
// true
```

### isNotEmpty(): bool
> Returns `bool`

Check if the bag is not empty
```php
$bag = new Utility([1, 2]);

$bag->isNotEmpty();
// true

$bag = new Utility([]);

$bag->isNotEmpty();
// false
```

### isSequential(): bool
> Returns `bool`

Is the bag holding sequentially indexed data
```php 
$bag = new Utility([0 => 'Tor', 1 => 'Fred', 2 => 'Chris']);

$bag->isSequential();
// true
$bag = new Utility([0 => 'Tor', 2 => 'Chris']);

$bag->isSequential();
// false
```

### join(string $joinGlue, string $lastGlue = null): string
> Returns `string`

Join the values of the bag with a given glue string, and additionally
with an optional last glue to create an alternate ending join.
```php 
$bag = new Utility([1,2,3,4,5,6,7,8,9,0]);

$bag->join(', ');
// 1, 2, 3, 4, 5, 6, 7, 8, 9, 0

$bag->join(', ', ' and ');
// 1, 2, 3, 4, 5, 6, 7, 8, 9 and 0
```

### jsonSerialize(): array
> Returns `array`

### keys(): array
> Returns `array`

Return array of root keys from the bag
```php 
$bag = new Utility([7, 48, 'corgi' => 'Rupert', 'ball_chaser' => 'Gerald']);

$bag->keys();
// [0, 1, 'corgi', 'ball_chaser']
```

### last(?callable $callback = null, mixed $default = null): mixed
> Returns `mixed`

Get the last item in the bag, optionally the last matching a condition
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->last();
// 5

$bag->last(fn ($value) => $value < 4);
// 3

$bag->last(fn ($value) => $value > 10, 'fallback');
// 'fallback'
```

### make($bag): Utility
> Returns `Utility`

Create a new instance of the bag utility
```php 
$bag = Utility::make(['Tor', 'Fred']);

$bag2 = Utility::make($bag)
```

### map(callable $mapper): Utility
> Returns `Utility`

Create a new bag containing the results of applying the callback to each value of the current bag.

```php 
$bag = new Utility([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

$bag->map(fn ($value) => $value * 7);

// [7, 14, 21, 28, 35, 42, 49, 56, 63, 70]
```

### mapKeys(callable $mapper): Utility
> Returns `Utility`

Remap the values of the bag with new index keys. The mapper receives the key and value, and should return a single key/value pair array.

```php 
$bag = new Utility([['name' => 'Fred', 'colour' => 'purple'], ['name' => 'Tor', 'colour' => 'pink']]);

$bag->mapKeys(fn ($index, $value) => [$value['name'] => $value]);

// ['Fred' => ['name' => 'Fred', 'colour' => 'purple'], 'Tor' => ['name' => 'Tor', 'colour' => 'pink']]
```

### max(string|callable|null $callback = null): mixed
> Returns `mixed`

Get the maximum value in the bag, optionally by key or callback
```php
$bag = new Utility([3, 1, 4, 1, 5]);

$bag->max();
// 5

$bag = new Utility([
    ['name' => 'Fred', 'age' => 30],
    ['name' => 'Chris', 'age' => 35],
]);

$bag->max('age');
// 35
```

### merge($bag): Utility
> Returns `Utility`

Merge an array or bag Utility into the current bag
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'value']]);

$bag->merge([1 => 'Chris', 'foo' => 'hello world']);
// ['Tor', 'Fred', 'Chris', 'foo' => 'hello world']]
```

### mergeRecursively($bag): Utility
> Returns `Utility`

Recursively merge an array or bag Utility into the current bag
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => ['bar' => 'value']]);

$bag->mergeRecursively([1 => 'Chris', 'foo' => 'hello world']);
// ['Tor', 'Fred', 'Chris', 'foo' => ['hello world', 'bar' => 'value']]
```

### min(string|callable|null $callback = null): mixed
> Returns `mixed`

Get the minimum value in the bag, optionally by key or callback
```php
$bag = new Utility([3, 1, 4, 1, 5]);

$bag->min();
// 1

$bag = new Utility([
    ['name' => 'Fred', 'age' => 30],
    ['name' => 'Tor', 'age' => 25],
]);

$bag->min('age');
// 25
```

### offsetExists($offset): bool
> Returns `bool`

### offsetGet($offset): mixed
> Returns `mixed`

### offsetSet($offset, $value): void
> Returns `void`

### offsetUnset($offset): void
> Returns `void`

### only(array|Utility $onlyKeys): Utility
> Returns `Utility`

Make a new bag with only the given keys
```php 
$bag = new Utility([
            'foo' => 'bar',
            'hello' => 'world',
            'fluffy' => 'corgi',
            'Rupert',
            'Gerald',
        ]);
        
$bag->only(['hello', 'fluffy',]);
// ['hello' => 'world', 'fluffy' => 'corgi']]
```

### pipe(callable $callback): mixed
> Returns `mixed`

Pass the bag to a callback and return the result
```php
$bag = new Utility([1, 2, 3]);

$bag->pipe(fn ($bag) => $bag->count());
// 3

$bag->pipe(fn ($bag) => $bag->push(4));
// Utility([1, 2, 3, 4])
```

### pluck(string $valuePath, ?string $keyPath = null): Utility
> Returns `Utility`

Extract a single column of values from a multi-dimensional bag
```php
$bag = new Utility([
    ['id' => 1, 'name' => 'Fred'],
    ['id' => 2, 'name' => 'Tor'],
]);

$bag->pluck('name');
// ['Fred', 'Tor']

$bag->pluck('name', 'id');
// [1 => 'Fred', 2 => 'Tor']
```

### prepend($value, $key = null): Utility
> Returns `Utility`

Add a value onto the beginning of the bag. Optionally supply a key to prepend under; a provided key that already exists is moved to the front with the new value.
```php
$bag = new Utility(['Fred', 'Chris']);

$bag->prepend('Tor')->toArray();
// ['Tor', 'Fred', 'Chris']

$bag = new Utility(['b' => 2, 'c' => 3]);

$bag->prepend(1, 'a')->toArray();
// ['a' => 1, 'b' => 2, 'c' => 3]
```

### push(...$values): Utility
> Returns `Utility`

Push value(s) onto the end of the bag
```php 
$bag = new Utility(['Tor', 'Fred']);

$bag->push('Chris');
// ['Tor', 'Fred', 'Chris']

$bag->push('Jack', 'Alex');
// ['Tor', 'Fred', 'Jack', 'Alex']
```

### reduce(callable $callback, mixed $initial = null): mixed
> Returns `mixed`

Reduce the bag to a single value using a callback
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->reduce(fn ($carry, $item) => $carry + $item, 0);
// 15

$bag = new Utility(['a', 'b', 'c']);

$bag->reduce(fn ($carry, $item) => $carry . $item, '');
// 'abc'
```

### reject(callable $callback, int $mode = ARRAY_FILTER_USE_BOTH): Utility
> Returns `Utility`

The inverse of [filter](#filter). Keep only the values for which the callback returns a falsey value. Like `filter`, the `$mode` controls what the callback receives (`ARRAY_FILTER_USE_BOTH` passes value and key, `ARRAY_FILTER_USE_KEY` passes only the key, `0` passes only the value).
```php
$bag = new Utility([1, 2, 3, 4, 5, 6]);

$bag->reject(fn ($value) => $value % 2 === 0)->toArray();
// [0 => 1, 2 => 3, 4 => 5]

$bag = new Utility(['keep' => 1, 'drop' => 2]);

$bag->reject(fn ($key) => $key === 'drop', ARRAY_FILTER_USE_KEY)->toArray();
// ['keep' => 1]
```

### remove(string|int $index): Utility
> Returns `Utility`

Remove a value from the bag via its index
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->remove(1)->value();
// ['Tor', 'foo' => 'bar']

$bag->remove('foo')->value();
// ['Tor', 'Fred']
```

### removeEmpty(): Utility
> Returns `Utility`

Remove all empty values from the bag
```php 
$bag = new Utility(['Tor', 'Fred', '', null]);

$bag->removeEmpty();
// ['Tor', 'Fred']
```

### resetIndex(): Utility
> Returns `Utility`

Resets the sequential index keys of the bag
```php
$bag = new Utility([1 => 7, 7 => 'x', 49 => 7, 77 => 49]);

$bag->resetIndex();
// [0 => 7, 1 => 'x', 2 => 7, 3 => 49];
```

### reverse(bool $preserveKeys = false): Utility
> Returns `Utility`

Reverse the order of items in the bag
```php
$bag = new Utility([1, 2, 3]);

$bag->reverse();
// [3, 2, 1]

$bag = new Utility(['a' => 1, 'b' => 2, 'c' => 3]);

$bag->reverse(preserveKeys: true);
// ['c' => 3, 'b' => 2, 'a' => 1]
```

### set(string|int $index, mixed $value): Utility
> Returns `Utility`

Set an array index with a given value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->set(1, 'Chris');
// ['Tor', 'Chris', 'foo' => 'bar']

$bag->set('foo', 'Chris');
// ['Tor', 'Fred', 'foo' => 'Chris']
```

### skip(int $count): Utility
> Returns `Utility`

Skip the given number of items from the start of the bag. A negative count keeps only that many items from the end. Keys are preserved.
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->skip(2)->toArray();
// [2 => 3, 3 => 4, 4 => 5]

$bag->skip(-2)->toArray();
// [3 => 4, 4 => 5]
```

### slice(int $offset, ?int $length = null): Utility
> Returns `Utility`

Return a slice of the bag starting at the given offset. A negative offset starts the slice that far from the end; a negative length stops the slice that far from the end. Keys are preserved.
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->slice(2)->toArray();
// [2 => 3, 3 => 4, 4 => 5]

$bag->slice(1, 2)->toArray();
// [1 => 2, 2 => 3]

$bag->slice(-2)->toArray();
// [3 => 4, 4 => 5]
```

### sort(?callable $callback = null): Utility
> Returns `Utility`

Sort the bag values, optionally with a custom comparison callback
```php
$bag = new Utility([3, 1, 4, 1, 5]);

$bag->sort();
// [1, 1, 3, 4, 5]

$bag->sort(fn ($a, $b) => $b <=> $a);
// [5, 4, 3, 1, 1]
```

### sortBy(string|callable $keyOrCallback, bool $descending = false): Utility
> Returns `Utility`

Sort the bag by a given key or callback
```php
$bag = new Utility([
    ['name' => 'Fred', 'age' => 30],
    ['name' => 'Tor', 'age' => 25],
    ['name' => 'Chris', 'age' => 35],
]);

$bag->sortBy('age');
// [['name' => 'Tor', ...], ['name' => 'Fred', ...], ['name' => 'Chris', ...]]

$bag->sortBy('age', descending: true);
// [['name' => 'Chris', ...], ['name' => 'Fred', ...], ['name' => 'Tor', ...]]
```

### sum(string|callable|null $callback = null): int|float
> Returns `int|float`

Get the sum of values in the bag, optionally by key or callback
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->sum();
// 15

$bag = new Utility([
    ['name' => 'Fred', 'score' => 10],
    ['name' => 'Tor', 'score' => 20],
]);

$bag->sum('score');
// 30
```

### take(int $limit): Utility
> Returns `Utility`

Take the first given number of items from the bag. A negative limit takes that many items from the end. Keys are preserved.
```php
$bag = new Utility([1, 2, 3, 4, 5]);

$bag->take(3)->toArray();
// [1, 2, 3]

$bag->take(-2)->toArray();
// [3 => 4, 4 => 5]
```

### toArray(): array
> Returns `array`

Get the bag as an array
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->toArray();
// ['Tor', 'Fred', 'foo' => 'bar']
```

### toKeyValueString(string $glue = ' ', string $keyPrefix = '', string $keyPostfix = '', string $keyJoint = '=', string $valuePrefix = '\'', string $valuePostfix = '\''): string
> Returns `string`

Implode the bag to show a key=value string
```php 
$bag = new Utility(['hello' => 'world', 'foo' => 'bar']);

$bag->toKeyValueString();
// "hello='world' foo='bar'"

$bag->toKeyValueString(', ', '*', '*', '~', '>', '<');
// "*hello*~>world<, *foo*~>bar<"
```

### toObject(): object
> Returns `object`

Get the bag as an stdClass object

### unique(?callable $callback = null): Utility
> Returns `Utility`

Return a new bag with only unique values
```php
$bag = new Utility([1, 2, 2, 3, 3, 3]);

$bag->unique();
// [1, 2, 3]

$bag = new Utility([
    ['name' => 'Fred', 'role' => 'dev'],
    ['name' => 'Tor', 'role' => 'dev'],
    ['name' => 'Chris', 'role' => 'design'],
]);

$bag->unique(fn ($item) => $item['role']);
// [['name' => 'Fred', ...], ['name' => 'Chris', ...]]
```

### value()
> Returns `array`

Get the bags current value
```php 
$bag = new Utility(['Tor', 'Fred', 'foo' => 'bar']);

$bag->value();
// ['Tor', 'Fred', 'foo' => 'bar']
```

### values()
> Returns `array`

Get the bags values (ignoring indexes)
```php 
$bag = new Utility([77 => 49, 'corgi' => 'Gerald', 'owner' => 'Fred']);

$bag->values();
// [49, 'Gerald', 'Fred']
```