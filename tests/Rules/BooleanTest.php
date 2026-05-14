<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class BooleanTest extends Testcase
{
    public function test_failed_if_boolean_not_bool()
    {
        $data = array('flag' => 'yes');
        $valid = $this->resolveRule($data, 'flag', 'boolean');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_boolean_valid()
    {
        $data = array('flag' => true);
        $valid = $this->resolveRule($data, 'flag', 'boolean');
        $this->assertTrue($valid->passed());
    }
}
