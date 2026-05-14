<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class DateFormatTest extends Testcase
{
    public function test_failed_if_dateformat_invalid()
    {
        $data = array('date' => '01-01-2023');
        $valid = $this->resolveRule($data, 'date', 'dateFormat:Y-m-d');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_dateformat_valid()
    {
        $data = array('date' => '2023-01-01');
        $valid = $this->resolveRule($data, 'date', 'dateFormat:Y-m-d');
        $this->assertTrue($valid->passed());
    }
}
