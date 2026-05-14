<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class AsciiTest extends Testcase
{
    public function test_failed_if_ascii_not_ascii()
    {
        $data = array('name' => "J\xC3\xA1ne");
        $valid = $this->resolveRule($data, 'name', 'ascii');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_ascii_valid()
    {
        $data = array('name' => 'Jane');
        $valid = $this->resolveRule($data, 'name', 'ascii');
        $this->assertTrue($valid->passed());
    }

    public function test_passed_if_ascii_empty()
    {
        $data = array('name' => '');
        $valid = $this->resolveRule($data, 'name', 'ascii');
        $this->assertTrue($valid->passed());
    }
}
