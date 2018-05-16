<?php
declare(strict_types=1);

namespace Pwm\TC\Concrete;

use Pwm\TC\TypedCollection;

final class CallableCollection extends TypedCollection
{
    public function __construct(...$callables)
    {
        parent::__construct(function (callable $callable) {
            return $callable;
        }, $callables);
    }
}
