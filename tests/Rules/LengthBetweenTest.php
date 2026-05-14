<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class LengthBetweenTest extends Testcase
{
    public function test_failed_if_lengthbetween_out_of_range()
    {
        $data = array('name' => 'too long');
        $valid = $this->resolveRule($data, 'name', 'lengthBetween:1,5');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_lengthbetween_valid()
    {
        $data = array('name' => 'abc');
        $valid = $this->resolveRule($data, 'name', 'lengthBetween:1,5');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_lengthbetween_non_string()
    {
        $data = array('name' => 123);
        $valid = $this->resolveRule($data, 'name', 'lengthBetween:1,5');
        $this->assertFalse($valid->passed());
    }
}
