<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class RegexTest extends Testcase
{
    public function test_failed_if_regex_not_match()
    {
        $data = array('name' => 'hello');
        $valid = $this->resolveRule($data, 'name', 'regex:/^[0-9]+$/');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_regex_valid()
    {
        $data = array('name' => '12345');
        $valid = $this->resolveRule($data, 'name', 'regex:/^[0-9]+$/');
        $this->assertTrue($valid->passed());
    }
}
