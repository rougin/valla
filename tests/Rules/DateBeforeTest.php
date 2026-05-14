<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class DateBeforeTest extends Testcase
{
    public function test_failed_if_datebefore_after()
    {
        $data = array('date' => '2024-01-01');
        $valid = $this->resolveRule($data, 'date', 'dateBefore:2023-01-01');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_datebefore_valid()
    {
        $data = array('date' => '2020-01-01');
        $valid = $this->resolveRule($data, 'date', 'dateBefore:2023-01-01');
        $this->assertTrue($valid->passed());
    }
}
