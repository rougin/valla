<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class AcceptedTest extends Testcase
{
    public function test_failed_if_accepted_invalid()
    {
        $data = array('terms' => 'no');
        $valid = $this->resolveRule($data, 'terms', 'accepted');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_accepted_valid()
    {
        $data = array('terms' => 'yes');
        $valid = $this->resolveRule($data, 'terms', 'accepted');
        $this->assertTrue($valid->passed());
    }
}
