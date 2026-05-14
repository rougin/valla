<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredWithoutTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_requiredwithout_field_exists()
    {
        $data = array('email' => '', 'name' => 'John');

        $valid = $this->resolveRule($data, 'email', 'requiredWithout:name');

        $this->assertTrue($valid->passed());
    }
}
