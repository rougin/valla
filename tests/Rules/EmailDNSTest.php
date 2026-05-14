<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class EmailDNSTest extends Testcase
{
    public function test_failed_if_emaildns_invalid()
    {
        $data = array('email' => 'test@nonexistent-domain.invalid');
        $valid = $this->resolveRule($data, 'email', 'emailDNS');
        $this->assertFalse($valid->passed());
    }

    public function test_failed_if_emaildns_non_string()
    {
        $data = array('email' => 123);
        $valid = $this->resolveRule($data, 'email', 'emailDNS');
        $this->assertFalse($valid->passed());
    }

    public function test_failed_if_emaildns_invalid_format()
    {
        $data = array('email' => 'not-an-email');
        $valid = $this->resolveRule($data, 'email', 'emailDNS');
        $this->assertFalse($valid->passed());
    }
}
