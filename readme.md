# Typed Collections

[![Build Status](https://travis-ci.org/pwm/tc.svg?branch=master)](https://travis-ci.org/pwm/tc)
[![codecov](https://codecov.io/gh/pwm/tc/branch/master/graph/badge.svg)](https://codecov.io/gh/pwm/tc)
[![Maintainability](https://api.codeclimate.com/v1/badges/8e83d3bb3cbb6e06ec67/maintainability)](https://codeclimate.com/github/pwm/tc/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8e83d3bb3cbb6e06ec67/test_coverage)](https://codeclimate.com/github/pwm/tc/test_coverage)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

`TypedCollection` is a simple abstract collection class that type checks its elements upon creation ensuring a typed collection. 

Collections created using `TypedCollection` are immutable, iterable, countable and listable. If you need a mutable container you can simply subtype it and add the relevant mutators.

The library comes with a few concrete implementations, namely: Bool, Callable, Float, Int and String collections, but it's trivial to implement your own custom typed collection using any custom type.

## Table of Contents

* [Why](#why)
* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [How it works](#how-it-works)
* [Tests](#tests)
* [Changelog](#changelog)
* [Licence](#licence)

## Why

With the advent of PHP7 the language started supporting type declarations to a degree, so we can finally write code like:

```php
function isEven(int $x): bool {
    return $x % 2 === 0;
}
```

where it is guaranteed that `$x` is an `int` as the return type is `bool`. On the other hand we still can't say things like we want to get a list of integers, ie.:

```php
function sum(int[] $xs): int { // can't write int[], only array
    return array_sum($xs);
}
```

is not valid php syntax. We can only use `array` as type declaration here and thus something nonsensical like `sum([1, 'a', false])` can't be caught by the type checker.

Taking the above one step further it's perfectly valid to only want to guarantee that elements of a list are of a specific type, regardless of what the actual type is. This might sounds strange at first, so here is an example:

```php
$addOne = function (int $x): int { return $x + 1; };
$toUpper = function (string $s): string { return strtoupper($s); };

array_map($addOne, [1, 2, 3]);
array_map($toUpper, ['a', 'b', 'c']);
```

Map cares neither about its function's argument type nor about the type of elements of its list. It only cares about 2 things:

 * That the list's elements are of all the same type
 * That this type is the same as the function's argument type

With PHP's `array` we can't guarantee either. With `TypedCollection` we can guarantee the first:

```php
function map(callable $f, TypedCollection $c) {
    return array_map($f, $c->toList());
}
```

guarantees that elements of `$c` are of the same type, ie.:

```php
map($addOne, new IntCollection(1, 2, 3)); // [2, 3, 4]
map($toUpper, new StringCollection('a', 'b', 'c')); // ['A', 'B', 'C']
```

but

```php
map($addOne, new IntCollection(1, 'a', false)); // Fatal error: Uncaught TypeError
```

A small but important step towards more type safe and robust code.

## Requirements

PHP 7.1+

## Installation

    $ composer require pwm/tc

## Usage

To create a concrete typed collection we extend `TypedCollection` and supply a function with a type declaration to it.

As an example here is the integer collection:

```php
class IntCollection extends TypedCollection
{
    public function __construct(...$ints)
    {
        parent::__construct(function (int $int) {
            return $int;
        }, $ints);
    }
}
```

To use it:

```php
$intCollection = new IntCollection(1, 2, 3);

// iterable
foreach ($intCollection as $element) {
    assert(is_int($element) === true);
}

// countable
assert(count($intCollection) === 3);

// listable
assert($intCollection->toList() === [1, 2, 3]);
```

Basic scalar typed collections, ie. bool, callable, float, int and string is part of the lib for convenience.
 
## How it works

The trick is to supply a function to `TypedCollection` that requires its argument to be of a particular type. For this we just use PHP's built in function type declaration. This works with built in types as well as user defined types (aka. classes). `TypedCollection` also checks that the supplied type checker function really does type check, ie. it does throw if it gets an untyped function.

`TypedCollection` implements the `IteratorAggregate` and `Countable` interfaces for ease of use. `getIterator()` returns a `Generator` which aligns well with the immutable semantics of the collection, ie. you can iterate it accessing its elements, without having access to the container itself.

To get the underlying mutable array representation use `toList()`. This is useful for using map/filter/reduce.

## Tests

	$ vendor/bin/phpunit
	$ composer phpcs
	$ composer phpstan

## Changelog

[Click here](changelog.md)

## Licence

[MIT](LICENSE)
