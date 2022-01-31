<?php

namespace Tests\Support;

use stdClass;

class BagConstructorTestCase
{

    public $var4;
    public $var5;
    public $var1 = 1;

    public $var2 = 'two';

    public $var3;

    public function __construct()
    {
        $this->var4 = new stdClass();

        $this->var5 = [
            'hello',
            'world',
        ];
    }

    public function __toString()
    {
        return 'BagConstructorTestCase::class';
    }
}
