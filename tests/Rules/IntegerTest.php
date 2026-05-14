<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class IntegerTest extends Testcase
{
    public function test_failed_if_integer_not_integer()
    {
        $data = array('age' => 'abc');
        $valid = $this->resolveRule($data, 'age', 'integer');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_integer_valid()
    {
        $data = array('age' => 20);
        $valid = $this->resolveRule($data, 'age', 'integer');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_integer_strict_mode()
    {
        $data = array('age' => '020');
        $valid = $this->resolveRule($data, 'age', 'integer:true');
        $this->assertFalse($valid->passed());
    }
}
