<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class FoobarCollection extends TypedCollection
{
    public function __construct(...$foobars)
    {
        parent::__construct(function (Foobar $foobar) {
            return $foobar;
        }, $foobars);
    }
}
