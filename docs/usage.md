# Usage

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

### Example Usage

#### Get
```php
$bag->get('my.deep.nested.value', 'default value');
```

#### Set
```php
$bag->set('my.deep.nested.value', 'is this');
```

#### Remove
```php
$bag->remove('my.deep.nested.value');
```

### How DotUtility differs from Utility

- Keys containing a dot are expanded into nested arrays when the bag is created, so `['a.b' => 1]` becomes `['a' => ['b' => 1]]`. A key with a literal dot cannot be stored.
- `set()` creates missing levels, and overwrites a level that holds a scalar with an array.
- `merge()` and `mergeRecursively()` expand dotted keys in the bag being merged in.
- `remove()` follows dot paths. A plain `Utility` only removes a literal key.
- A plain `Utility` also reads dot paths with `get()` and `exists()`. `exists('a.b')` is true for a literal `'a.b'` key, and `get('a.b')` returns it too. Otherwise both follow the dot path.

## Immutability

Every method returns a new bag and leaves the original unchanged. The exceptions are array syntax writes, `$bag['key'] = 'value'` and `unset($bag['key'])`, which change the bag in place because `ArrayAccess` cannot return a new bag.
