<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class InTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_in_value_not_found()
    {
        $data = array('role' => 'guest');

        $valid = $this->resolveRule($data, 'role', 'in:admin,editor');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_in_value_found()
    {
        $data = array('role' => 'admin');

        $valid = $this->resolveRule($data, 'role', 'in:admin,editor');

        $this->assertTrue($valid->passed());
    }
}
