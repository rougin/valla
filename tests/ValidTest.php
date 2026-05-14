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
    public function test_passed_if_valid_data()
    {
        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->addRule('name', 'required');

        $this->assertTrue($valid->passed());

        $this->assertNull($valid->firstError());
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
    public function test_failed_if_custom_rule()
    {
        $data = array('name' => 'John');

        $valid = new Valid($data);

        $valid->setRuleset(new Ruleset);

        $valid->addRule('name', 'required');

        $this->assertTrue($valid->passed());
    }
}
