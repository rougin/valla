<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\Testcase;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreditCardTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_creditcard_invalid_type()
    {
        $data = array('card' => array());

        $valid = $this->resolveRule($data, 'card', 'creditCard');

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_failed_if_creditcard_cleaned_nonnumeric()
    {
        $data = array('card' => 'abc-def-ghi');

        $valid = $this->resolveRule($data, 'card', 'creditCard');

        $this->assertFalse($valid->passed());
    }
}
