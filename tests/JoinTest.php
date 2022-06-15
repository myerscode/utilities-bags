<?php

namespace Tests;

use Tests\Support\BaseBagSuite;

class JoinTest extends BaseBagSuite
{
    public function testBagIsJoined(): void
    {
        $values = [1,2,3,4,5,6,7,8,9,0];

        $this->assertEquals(
            '1, 2, 3, 4, 5, 6, 7, 8, 9, 0',
            $this->utility($values)->join(', ')
        );

        $this->assertEquals(
            '1, 2, 3, 4, 5, 6, 7, 8, 9 and 0',
            $this->utility($values)->join(', ', ' and ')
        );
    }

    public function testBagWithKeyValuesIsJoined(): void
    {
        $values = ['owner' => 'Fred', 'corgi_one' => 'Gerald', 'corgi_two' => 'Rupert'];

        $this->assertEquals(
            'Fred, Gerald, Rupert',
            $this->utility($values)->join(', ')
        );

        $this->assertEquals(
            'Fred, Gerald and Rupert',
            $this->utility($values)->join(', ', ' and ')
        );
    }
}
