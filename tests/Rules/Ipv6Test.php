<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class Ipv6Test extends Testcase
{
    public function test_failed_if_ipv6_invalid()
    {
        $data = array('ip' => '192.168.1.1');
        $valid = $this->resolveRule($data, 'ip', 'ipv6');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_ipv6_valid()
    {
        $data = array('ip' => '::1');
        $valid = $this->resolveRule($data, 'ip', 'ipv6');
        $this->assertTrue($valid->passed());
    }
}
