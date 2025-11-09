<?php

namespace Rougin\Valla;

use Valitron\Validator;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RuleTest extends Testcase
{
    /**
     * @return void
     */
    public function test_contains()
    {
        // Arrange
        $data = array('name' => 'John');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('name', 'contains:Doe');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_credit_card()
    {
        // Arrange
        $data = array('card' => '123456789');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('card', 'creditCard');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_instance_of()
    {
        // Arrange
        $data = array('obj' => new \stdClass);

        $rule = new Rule(new Validator($data));

        // Act
        $class = 'Rougin\Valla\Fixture\DummyClass';

        $check = $rule->parse('obj', 'instanceOf:' . $class);

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_multi_params()
    {
        // Arrange
        $data = array('password' => '12345');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('password_confirmation', 'requiredWith:password');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_multiple_rules()
    {
        // Arrange
        $data = array('email' => 'not-an-email');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('email', 'required|email');

        $actual = $check->validate();

        /** @var array<string, string[]> */
        $errors = $check->errors();

        // Assert
        $expect = 'Email is not a valid email address';

        $actual = $errors['email'][0];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_not_in()
    {
        // Arrange
        $data = array('role' => 'admin');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('role', 'notIn:admin,editor');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_required_without()
    {
        // Arrange
        $data = array('email' => '');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('email', 'requiredWithout:name');
        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_single_param()
    {
        // Arrange
        $data = array('name' => 'Jo');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('name', 'lengthMin:5');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_single_rule()
    {
        // Arrange
        $data = array('name' => '');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('name', 'required');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_special_rules()
    {
        // Arrange
        $data = array('role' => 'guest');

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('role', 'in:admin,editor');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_subset_rule()
    {
        // Arrange
        $data = array('options' => array('a', 'd'));

        $rule = new Rule(new Validator($data));

        // Act
        $check = $rule->parse('options', 'subset:a,b,c');

        $actual = $check->validate();

        // Assert
        $this->assertFalse($actual);
    }
}
