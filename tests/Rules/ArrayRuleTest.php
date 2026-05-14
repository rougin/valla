<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class ArrayRuleTest extends Testcase
{
    public function test_failed_if_array_not_array()
    {
        $data = array('items' => 'string');
        $valid = $this->resolveRule($data, 'items', 'array');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_array_valid()
    {
        $data = array('items' => array(1, 2));
        $valid = $this->resolveRule($data, 'items', 'array');
        $this->assertTrue($valid->passed());
    }
}
