<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredWithTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_requiredwith_field_missing()
    {
        $data = array('email' => '');

        $valid = $this->resolveRule($data, 'email', 'requiredWith:name');

        $this->assertTrue($valid->passed());
    }
}
