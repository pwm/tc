<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class BoolCollection extends TypedCollection
{
    public function __construct(array $bools)
    {
        parent::__construct(function (bool $bool) {
            return $bool;
        }, $bools);
    }
}
