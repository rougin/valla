<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class DifferentTest extends Testcase
{
    public function test_failed_if_different_same()
    {
        $data = array('a' => 'hello', 'b' => 'hello');
        $valid = $this->resolveRule($data, 'a', 'different:b');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_different_valid()
    {
        $data = array('a' => 'hello', 'b' => 'world');
        $valid = $this->resolveRule($data, 'a', 'different:b');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_different_field_missing()
    {
        $data = array('a' => 'hello');
        $valid = $this->resolveRule($data, 'a', 'different:b');
        $this->assertFalse($valid->passed());
    }
}
