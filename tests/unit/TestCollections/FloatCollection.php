<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class FloatCollection extends TypedCollection
{
    public function __construct(...$floats)
    {
        parent::__construct(function (float $float) {
            return $float;
        }, $floats);
    }
}
