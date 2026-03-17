<?php

declare(strict_types=1);

namespace Tests;

use Tests\Support\BaseBagSuite;

final class JsonSerializeTest extends BaseBagSuite
{
    public function test_json_encoding_returns_json(): void
    {
        $values = ['foo' => 'bar'];

        $this->assertJsonStringEqualsJsonString(
            json_encode($values),
            json_encode($this->utility($values), JSON_THROW_ON_ERROR)
        );
    }
}
