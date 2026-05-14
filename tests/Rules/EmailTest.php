<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class EmailTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_email_not_string()
    {
        $data = array('email' => 123);

        $valid = $this->resolveRule($data, 'email', 'email');

        $this->assertFalse($valid->passed());
    }
}
