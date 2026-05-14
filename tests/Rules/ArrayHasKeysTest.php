<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class ArrayHasKeysTest extends Testcase
{
    public function test_failed_if_arrayhaskey_missing()
    {
        $data = array('data' => array('a' => 1));
        $valid = $this->resolveRule($data, 'data', 'arrayHasKeys:a,b');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_arrayhaskey_valid()
    {
        $data = array('data' => array('a' => 1, 'b' => 2));
        $valid = $this->resolveRule($data, 'data', 'arrayHasKeys:a,b');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_arrayhaskey_not_array()
    {
        $data = array('data' => 'string');
        $valid = $this->resolveRule($data, 'data', 'arrayHasKeys:a,b');
        $this->assertFalse($valid->passed());
    }
}
