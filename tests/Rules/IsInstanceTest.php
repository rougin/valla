<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class IsInstanceTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_instanceof_not_object()
    {
        $data = array('obj' => 'string');

        $valid = $this->resolveRule($data, 'obj', 'instanceOf:stdClass');

        $this->assertFalse($valid->passed());
    }
}
