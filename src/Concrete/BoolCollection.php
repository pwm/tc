<?php
declare(strict_types=1);

namespace Pwm\TC\Concrete;

use Pwm\TC\TypedCollection;

final class BoolCollection extends TypedCollection
{
    public function __construct(...$bools)
    {
        parent::__construct(function (bool $bool) {
            return $bool;
        }, $bools);
    }
}
