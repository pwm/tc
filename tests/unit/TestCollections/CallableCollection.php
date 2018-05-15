<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class CallableCollection extends TypedCollection
{
    public function __construct(array $callables)
    {
        parent::__construct(function (callable $callable) {
            return $callable;
        }, $callables);
    }
}
