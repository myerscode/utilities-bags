# Dot Utility Usage

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
