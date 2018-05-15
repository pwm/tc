<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollections;

use Pwm\TC\TypedCollection;

final class StringCollection extends TypedCollection
{
    public function __construct(...$strings)
    {
        parent::__construct(function (string $string) {
            return $string;
        }, $strings);
    }
}
