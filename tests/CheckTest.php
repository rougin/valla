<?php

namespace Rougin\Valla;

use Rougin\Valla\Fixture\DynamicCheck;
use Rougin\Valla\Fixture\SampleCheck;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CheckTest extends Testcase
{
    /**
     * @return void
     */
    public function test_custom_error()
    {
        // Arrange
        $check = new Check;

        $check->setError('custom', 'This is a custom error.');

        // Act
        $check->valid(array());

        $errors = $check->errors();

        // Assert
        $expect = 'This is a custom error.';

        $actual = $errors['custom'][0];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_dynamic_rules()
    {
        // Arrange
        $check = new DynamicCheck;

        $data = array('is_company' => true);

        $data['company_name'] = '';

        // Act
        $check->valid($data);

        $errors = $check->errors();

        // Assert
        $expect = 'Company Name is required';

        $actual = $errors['company_name'][0];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_errors()
    {
        // Arrange
        $data = array('email' => 'not-an-email');

        $check = new SampleCheck;

        // Act
        $check->valid($data);

        $errors = $check->errors();

        // Assert
        $expect = 'Email is not a valid email address';

        $actual = $errors['email'][0];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_first_error()
    {
        // Arrange
        $check = new SampleCheck;

        $data = array('name' => '');

        $data['email'] = 'johndoe@gmail.com';

        $data['age'] = 20;

        // Act
        $check->valid($data);

        $actual = $check->firstError();

        // Assert
        $expect = 'Name is required';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_invalid_data()
    {
        // Arrange
        $check = new SampleCheck;

        $data = array('name' => '');

        $data['email'] = 'not-an-email';

        $data['age'] = 'not-numeric';

        // Act
        $actual = $check->valid($data);

        // Assert
        $this->assertFalse($actual);
    }

    /**
     * @return void
     */
    public function test_no_errors()
    {
        // Arrange
        $check = new SampleCheck;

        $data = array('name' => 'John Doe');

        $data['email'] = 'johndoe@gmail.com';

        $data['age'] = 20;

        // Act
        $check->valid($data);

        $actual = $check->firstError();

        // Assert
        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_valid_data()
    {
        // Arrange
        $check = new SampleCheck;

        $data = array('name' => 'John Doe');

        $data['email'] = 'johndoe@gmail.com';

        $data['age'] = 20;

        // Act
        $actual = $check->valid($data);

        // Assert
        $this->assertTrue($actual);
    }
}
