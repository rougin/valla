<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class Ipv4Test extends Testcase
{
    public function test_failed_if_ipv4_invalid()
    {
        $data = array('ip' => '::1');
        $valid = $this->resolveRule($data, 'ip', 'ipv4');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_ipv4_valid()
    {
        $data = array('ip' => '192.168.1.1');
        $valid = $this->resolveRule($data, 'ip', 'ipv4');
        $this->assertTrue($valid->passed());
    }
}
