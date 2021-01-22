<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class JsonSerializeTest extends BaseBagSuite
{
    public function testJsonEncodingReturnsJson()
    {
        $values = ['foo' => 'bar'];

        $this->assertJsonStringEqualsJsonString(
            json_encode($values),
            json_encode($this->utility($values))
        );
    }
}
