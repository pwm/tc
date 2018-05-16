<?php
declare(strict_types=1);

namespace Pwm\TC\Concrete;

use Pwm\TC\TypedCollection;

final class IntCollection extends TypedCollection
{
    public function __construct(...$ints)
    {
        parent::__construct(function (int $int) {
            return $int;
        }, $ints);
    }
}
