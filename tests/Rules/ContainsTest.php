<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ContainsTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_contains_not_string()
    {
        $data = array('name' => 123);

        $valid = $this->resolveRule($data, 'name', 'contains:Doe');

        $this->assertFalse($valid->passed());
    }
}
