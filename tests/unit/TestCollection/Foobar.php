<?php
declare(strict_types=1);

namespace Pwm\TC\TestCollection;

final class Foobar
{
    /** @var int */
    public $foo;
    /** @var string */
    public $bar;

    public function __construct(int $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
