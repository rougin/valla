<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class AlphaNumTest extends Testcase
{
    public function test_failed_if_alphanum_not_alphanumeric()
    {
        $data = array('name' => 'test!@#');
        $valid = $this->resolveRule($data, 'name', 'alphaNum');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_alphanum_valid()
    {
        $data = array('name' => 'Test123');
        $valid = $this->resolveRule($data, 'name', 'alphaNum');
        $this->assertTrue($valid->passed());
    }
}
