<?php
declare(strict_types=1);

namespace Pwm\TC;

use Closure;
use Countable;
use Generator;
use IteratorAggregate;
use ReflectionFunction;
use TypeError;

abstract class TypedCollection implements IteratorAggregate, Countable
{
    /** @var array */
    protected $elements;

    public function __construct(Closure $typeChecker, array $elements)
    {
        self::ensureTypeCheckerIsTyped($typeChecker);

        $this->elements = \array_map(function ($element) use ($typeChecker) {
            return $typeChecker($element);
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

    private static function ensureTypeCheckerIsTyped(Closure $typeChecker): void
    {
        $params = (new ReflectionFunction($typeChecker))->getParameters();
        if (\count($params) !== 1 || ! $params[0]->hasType()) {
            throw new TypeError('The supplied type checker function is not typed.');
        }
    }
}
