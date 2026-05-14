<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMinTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_lengthmin_not_string()
    {
        $data = array('name' => 123);

        $valid = $this->resolveRule($data, 'name', 'lengthMin:5');

        $this->assertFalse($valid->passed());
    }
}
