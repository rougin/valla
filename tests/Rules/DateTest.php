<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class DateTest extends Testcase
{
    public function test_failed_if_date_invalid()
    {
        $data = array('birthday' => 'not-a-date');
        $valid = $this->resolveRule($data, 'birthday', 'date');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_date_valid()
    {
        $data = array('birthday' => '2023-01-01');
        $valid = $this->resolveRule($data, 'birthday', 'date');
        $this->assertTrue($valid->passed());
    }

    public function test_passed_if_date_datetime_object()
    {
        $data = array('birthday' => new \DateTime);
        $valid = $this->resolveRule($data, 'birthday', 'date');
        $this->assertTrue($valid->passed());
    }
}
