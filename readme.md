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
