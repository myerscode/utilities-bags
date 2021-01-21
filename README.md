# Bags Utilities
> A PHP helper utility class for fluent interaction and manipulation with collection data using immutable bags

[![Latest Stable Version](https://poser.pugx.org/myerscode/utilities-bags/v/stable)](https://packagist.org/packages/myerscode/utilities-bags)
[![Total Downloads](https://poser.pugx.org/myerscode/utilities-bags/downloads)](https://packagist.org/packages/myerscode/utilities-bags)
[![License](https://poser.pugx.org/myerscode/utilities-bags/license)](https://packagist.org/packages/myerscode/utilities-bags)
![License](https://github.com/myerscode/utilities-bags/workflows/Tests/badge.svg?branch=master)


## Install

You can install this package via composer:

``` bash
    composer require myerscode/utilities-bags
```

## Usage

Create an instance of the fluent interface by creating a new instance either via `new Utility($val)` or `Utility::make($val)`

``` php
$bag = new Utility(['Hello', 'World']);
$bag = Utility::make(['Hello', 'World']);
```

## Dot Notation Access

If you want to access your bag data using `dot.notation.accessors` (all keys as one string separated by a dot) then create
a `DotUtility` instance.

``` php
$bag = new DotUtility(['Hello', 'World']);
$bag = DotUtility::make(['Hello', 'World']);
```

### Available Methods

#### Get
```php
$bag->get('my.deep.nested.value', 'default value');
```

#### Set
```php
$bag->set('my.deep.nested.value', 'is this');
```

## Methods

The utility implements the core/SPL PHP `ArrayAccess`, `Countable`, `IteratorAggregate` interfaces, so can be used as per 
the documentation [here](http://php.net/manual/en/reserved.interfaces.php) and [here](http://php.net/manual/en/spl.interfaces.php). 



#### add($index, $value): Utility
Add a new value a specified index to the bag

#### contains($needles): bool
Alias of containsAny

#### containsAll($needles): bool
Are all the values in the needle bag in the haystack bag

#### containsAny($needles): bool
Are any of the needle values in the haystack bag

#### count(): int

#### get($index, $default = null)
Get a value from a given index or return a default value

####  getIterator(): \ArrayIterator

#### isAssociative(): bool
Is the bag holding associative data

### isIndexed: bool
Is the bag holding indexed data

#### isMultiDimensional(): bool
Is the bag holding multidimensional data

### isSequential: bool
Is the bag holding sequentially indexed data

#### make($bag): Utility
Create a new instance of the bag utility

#### offsetExists($offset): bool

#### offsetGet($offset)

#### offsetSet($offset, $value): Utility

#### offsetUnset($offset): Utility

#### push(...$values): Utility
Push value/s onto the end of the bag

#### remove($index): Utility
Remove an value from the bag via its index

#### removeEmpty(): Utility
Remove all empty values from the bag

#### set($index, $value): Utility
Set an array index with a given value

#### toArray(): array
Get the bag as an array

#### toKeyValueString($glue = ' ', $keyPrefix = '', $keyPostfix = '', $keyJoint = '=', $valuePrefix = '\'', $valuePostfix = '\''): string
Implode the the bag to show a key=value string

#### toObject(): object
Get the bag as an object

#### value()
Get the bags current value


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
