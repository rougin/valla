<?php

namespace Rougin\Valla;

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('name', 'contains:Doe');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('card', 'creditCard');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $class = 'Rougin\Valla\Fixture\DummyClass';

        $valid = $rule->match('obj', 'instanceOf:' . $class);

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('password_confirmation', 'requiredWith:password');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('email', 'required|email');

        $actual = $valid->passed();

        $errors = $valid->getErrors();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('role', 'notIn:admin,editor');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('email', 'requiredWithout:name');
        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('name', 'lengthMin:5');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('name', 'required');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('role', 'in:admin,editor');

        $actual = $valid->passed();

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

        $rule = new Rule(new Valid($data));

        // Act
        $valid = $rule->match('options', 'subset:a,b,c');

        $actual = $valid->passed();

        // Assert
        $this->assertFalse($actual);
    }
}
