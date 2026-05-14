<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_required_strict_null()
    {
        $data = array('name' => null);

        $valid = $this->resolveRule($data, 'name', 'required:true');

        $this->assertFalse($valid->passed());
    }
}
