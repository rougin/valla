<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class BetweenTest extends Testcase
{
    public function test_failed_if_between_out_of_range()
    {
        $data = array('age' => 25);
        $valid = $this->resolveRule($data, 'age', 'between:1,20');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_between_valid()
    {
        $data = array('age' => 15);
        $valid = $this->resolveRule($data, 'age', 'between:1,20');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_between_non_numeric()
    {
        $data = array('age' => 'abc');
        $valid = $this->resolveRule($data, 'age', 'between:1,20');
        $this->assertFalse($valid->passed());
    }
}
