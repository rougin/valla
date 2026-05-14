<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NumericTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_numeric_not_numeric()
    {
        $data = array('age' => 'abc');

        $valid = $this->resolveRule($data, 'age', 'numeric');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_numeric_is_numeric()
    {
        $data = array('age' => 20);

        $valid = $this->resolveRule($data, 'age', 'numeric');

        $this->assertTrue($valid->passed());
    }
}
