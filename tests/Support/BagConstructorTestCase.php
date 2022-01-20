<?php

namespace Tests\Support;

use stdClass;
use Stringable;

class BagConstructorTestCase implements Stringable
{
    public stdClass $var4;

    public array $var5;

    public int $var1 = 1;

    public string $var2 = 'two';

    public $var3;

    public function __construct()
    {
        $this->var4 = new stdClass();

        $this->var5 = [
            'hello',
            'world',
        ];
    }

    public function __toString(): string
    {
        return 'BagConstructorTestCase::class';
    }
}
