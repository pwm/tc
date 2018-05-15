<?php
declare(strict_types=1);

namespace Pwm\TC;

use Countable;
use Generator;
use IteratorAggregate;

abstract class TypedCollection implements IteratorAggregate, Countable
{
    /** @var array */
    protected $elements;

    public function __construct(callable $typeCheck, array $elements)
    {
        $this->elements = \array_map(function ($element) use ($typeCheck) {
            return $typeCheck($element);
        }, $elements);
    }

    public function toList(): array
    {
        return $this->elements;
    }

    public function getIterator(): Generator
    {
        yield from $this->elements;
    }

    public function count(): int
    {
        return \count($this->elements);
    }
}
