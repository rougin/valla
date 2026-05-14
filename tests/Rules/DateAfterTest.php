<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class DateAfterTest extends Testcase
{
    public function test_failed_if_dateafter_before()
    {
        $data = array('date' => '2020-01-01');
        $valid = $this->resolveRule($data, 'date', 'dateAfter:2023-01-01');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_dateafter_valid()
    {
        $data = array('date' => '2024-01-01');
        $valid = $this->resolveRule($data, 'date', 'dateAfter:2023-01-01');
        $this->assertTrue($valid->passed());
    }
}
