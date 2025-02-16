<?php

namespace Myerscode\Utilities\Bags;


if (!function_exists('bag')) {
    function bag(mixed $bag = []): Utility
    {
        return new Utility($bag);
    }
}