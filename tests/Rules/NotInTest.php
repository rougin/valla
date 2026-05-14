<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NotInTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_notin_value_found()
    {
        $data = array('role' => 'admin');

        $valid = $this->resolveRule($data, 'role', 'notIn:admin,editor');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_notin_value_not_found()
    {
        $data = array('role' => 'guest');

        $valid = $this->resolveRule($data, 'role', 'notIn:admin,editor');

        $this->assertTrue($valid->passed());
    }
}
