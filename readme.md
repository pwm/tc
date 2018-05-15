# Typed Collections

Typed collection is a simple abstract collection class that type checks its elements upon creation. Collections are iterable, countable and listable.

## Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [How it works](#how-it-works)
* [Tests](#tests)
* [Changelog](#changelog)
* [Licence](#licence)

## Requirements

PHP 7.1+

## Installation

    $ composer require pwm/tc

## Usage

To create a concrete typed collection we extend `TypedCollection` and supply a function with a type declaration to it.

Here is an example of an integer collection:

```php
class IntCollection extends TypedCollection
{
    public function __construct(array $ints)
    {
        parent::__construct(function (int $int) {
            return $int;
        }, $ints);
    }
}
```

Now we can use our int collection:

```php
$intCollection = new IntCollection([1, 2, 3]);

// iterable
foreach ($intCollection as $element) {
    assert(is_int($element) === true);
}

// countable
assert(count($intCollection) === 3);

// listable
assert($intCollection->toList() === [1, 2, 3]);
```
 
## How it works

The trick is to supply a function to `TypedCollection` that requires its argument to be of a particular type. For this we just use PHP's built in function type declaration. This works with built in types as well as user defined types (aka. classes).

It also implements the `IteratorAggregate` and `Countable` interfaces.

Use `->toList()` to get the underlying list representation. This is useful for using it with map/filter/reduce.

## Tests

	$ vendor/bin/phpunit
	$ composer phpcs
	$ composer phpstan

## Changelog

[Click here](changelog.md)

## Licence

[MIT](LICENSE)
