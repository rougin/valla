<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class LengthTest extends Testcase
{
    public function test_failed_if_length_not_exact()
    {
        $data = array('name' => 'Jo');
        $valid = $this->resolveRule($data, 'name', 'length:5');
        $this->assertFalse($valid->passed());
    }

    public function test_failed_if_length_not_between()
    {
        $data = array('name' => 'too long');
        $valid = $this->resolveRule($data, 'name', 'length:1,5');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_length_valid()
    {
        $data = array('name' => 'abc');
        $valid = $this->resolveRule($data, 'name', 'length:3');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_length_non_string()
    {
        $data = array('name' => 123);
        $valid = $this->resolveRule($data, 'name', 'length:3');
        $this->assertFalse($valid->passed());
    }
}
