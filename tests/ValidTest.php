<?php

namespace Rougin\Valla;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ValidTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_custom_rule()
    {
        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->setRuleset(new Ruleset);

        $valid->addRule('name', 'required');

        $this->assertTrue($valid->passed());
    }

    /**
     * @return void
     */
    public function test_failed_if_invalid_data()
    {
        $data = array('name' => '');

        $valid = new Valid($data);

        $valid->addRule('name', 'required');

        $this->assertFalse($valid->passed());

        $this->assertNotNull($valid->firstError());
    }

    /**
     * @return void
     */
    public function test_failed_if_rule_is_callable()
    {
        $this->doExpectException('InvalidArgumentException');

        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->rule(function ()
        {
            return true;
        }, 'name');
    }

    /**
     * @return void
     */
    public function test_failed_if_rule_with_array_fields()
    {
        $data = array('name' => '', 'email' => '');

        $valid = new Valid($data);

        $valid->rule('required', array('name', 'email'));

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_failed_if_rule_with_parameter()
    {
        $data = array('age' => 3);

        $valid = new Valid($data);

        $valid->rule('min', 'age', 5);

        $this->assertFalse($valid->passed());
    }

    /**
     * @return void
     */
    public function test_passed_if_rule_with_string_field()
    {
        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->rule('required', 'name');

        $this->assertTrue($valid->passed());

        $this->assertNull($valid->firstError());
    }

    /**
     * @return void
     */
    public function test_passed_if_valid_data()
    {
        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->addRule('name', 'required');

        $this->assertTrue($valid->passed());

        $this->assertNull($valid->firstError());
    }
}
