<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class OptionalTest extends Testcase
{
    public function test_passed_if_optional_always()
    {
        $data = array('field' => '');
        $valid = $this->resolveRule($data, 'field', 'optional');
        $this->assertTrue($valid->passed());
    }

    public function test_passed_if_optional_error_method()
    {
        $rule = new \Rougin\Valla\Rules\Optional;
        $this->assertSame('is optional', $rule->getError());
    }
}
