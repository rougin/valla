<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class IpTest extends Testcase
{
    public function test_failed_if_ip_invalid()
    {
        $data = array('ip' => 'not-an-ip');
        $valid = $this->resolveRule($data, 'ip', 'ip');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_ip_valid()
    {
        $data = array('ip' => '127.0.0.1');
        $valid = $this->resolveRule($data, 'ip', 'ip');
        $this->assertTrue($valid->passed());
    }
}
