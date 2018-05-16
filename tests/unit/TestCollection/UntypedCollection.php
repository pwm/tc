<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollection;

use Pwm\TC\TypedCollection;

final class UntypedCollection extends TypedCollection
{
    public function __construct(...$mixed)
    {
        parent::__construct(function ($mixed) {
            return $mixed;
        }, $mixed);
    }
}
