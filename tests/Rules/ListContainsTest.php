<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class ListContainsTest extends Testcase
{
    public function test_failed_if_listcontains_missing()
    {
        $data = array('items' => array('a', 'b'));
        $valid = $this->resolveRule($data, 'items', 'listContains:c');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_listcontains_valid()
    {
        $data = array('items' => array('a', 'b', 'c'));
        $valid = $this->resolveRule($data, 'items', 'listContains:c');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_listcontains_not_array()
    {
        $data = array('items' => 'string');
        $valid = $this->resolveRule($data, 'items', 'listContains:c');
        $this->assertFalse($valid->passed());
    }
}
