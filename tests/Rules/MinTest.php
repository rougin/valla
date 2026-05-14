<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class MinTest extends Testcase
{
    public function test_failed_if_min_below()
    {
        $data = array('age' => 5);
        $valid = $this->resolveRule($data, 'age', 'min:10');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_min_valid()
    {
        $data = array('age' => 25);
        $valid = $this->resolveRule($data, 'age', 'min:10');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_min_non_numeric()
    {
        $data = array('age' => 'abc');
        $valid = $this->resolveRule($data, 'age', 'min:10');
        $this->assertFalse($valid->passed());
    }
}
