<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class EqualsTest extends Testcase
{
    public function test_failed_if_equals_not_match()
    {
        $data = array('a' => 'hello', 'b' => 'world');
        $valid = $this->resolveRule($data, 'a', 'equals:b');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_equals_valid()
    {
        $data = array('a' => 'hello', 'b' => 'hello');
        $valid = $this->resolveRule($data, 'a', 'equals:b');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_equals_field_missing()
    {
        $data = array('a' => 'hello');
        $valid = $this->resolveRule($data, 'a', 'equals:b');
        $this->assertFalse($valid->passed());
    }
}
