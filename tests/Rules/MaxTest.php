<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class MaxTest extends Testcase
{
    public function test_failed_if_max_exceeded()
    {
        $data = array('age' => 25);
        $valid = $this->resolveRule($data, 'age', 'max:20');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_max_valid()
    {
        $data = array('age' => 15);
        $valid = $this->resolveRule($data, 'age', 'max:20');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_max_non_numeric()
    {
        $data = array('age' => 'abc');
        $valid = $this->resolveRule($data, 'age', 'max:20');
        $this->assertFalse($valid->passed());
    }
}
