<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SubsetTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_subset_not_array()
    {
        $data = array('options' => 'string');

        $valid = $this->resolveRule($data, 'options', 'subset:a,b,c');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_subset_all_valid()
    {
        $data = array('options' => array('a', 'b'));

        $valid = $this->resolveRule($data, 'options', 'subset:a,b,c');

        $this->assertTrue($valid->passed());
    }
}
