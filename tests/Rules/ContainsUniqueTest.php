<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

class ContainsUniqueTest extends Testcase
{
    public function test_failed_if_containsunique_duplicate()
    {
        $data = array('items' => array('a', 'b', 'a'));
        $valid = $this->resolveRule($data, 'items', 'containsUnique');
        $this->assertFalse($valid->passed());
    }

    public function test_passed_if_containsunique_valid()
    {
        $data = array('items' => array('a', 'b', 'c'));
        $valid = $this->resolveRule($data, 'items', 'containsUnique');
        $this->assertTrue($valid->passed());
    }

    public function test_failed_if_containsunique_not_array()
    {
        $data = array('items' => 'string');
        $valid = $this->resolveRule($data, 'items', 'containsUnique');
        $this->assertFalse($valid->passed());
    }
}
