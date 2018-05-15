<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class ArrayCollection extends TypedCollection
{
    public function __construct(...$arrays)
    {
        parent::__construct(function (array $array) {
            return $array;
        }, $arrays);
    }
}
