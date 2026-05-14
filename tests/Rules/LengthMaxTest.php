<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMaxTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_lengthmax_exceeded()
    {
        $data = array('name' => 'too long string');

        $valid = $this->resolveRule($data, 'name', 'lengthMax:10');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_failed_if_lengthmax_not_string()
    {
        $data = array('name' => 123);

        $valid = $this->resolveRule($data, 'name', 'lengthMax:10');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_lengthmax_within_limit()
    {
        $data = array('name' => 'abc');

        $valid = $this->resolveRule($data, 'name', 'lengthMax:5');

        $this->assertTrue($valid->passed());
    }
}
