<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class AlphaTest extends Testcase
{
    public function test_failed_if_alpha_not_alpha()
    {
        $data = array('name' => '123');
        $valid = $this->resolveRule($data, 'name', 'alpha');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_alpha_valid()
    {
        $data = array('name' => 'John');
        $valid = $this->resolveRule($data, 'name', 'alpha');
        $this->assertTrue($valid->passed());
    }
}
