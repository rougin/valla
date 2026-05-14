# Valla

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

A simple validation package for PHP inspired by [Valitron](https://github.com/vlucas/valitron).

``` php
use Rougin\Valla\Check;

class UserCheck extends Check
{
    protected $labels = array(

        'name' => 'Name',
        'email' => 'Email',

    );

    protected $rules = array(

        'name' => 'required',
        'email' => 'required|email',

    );
}
```

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/valla
```

## Basic usage

The core of `Valla` is the `Check` class which is used to create a set of validation rules:

``` php
use Rougin\Valla\Check;

class UserCheck extends Check
{
    /**
     * @var array<string, string>
     */
    protected $labels = array(

        'age' => 'Age',
        'email' => 'Email',
        'name' => 'Name',

    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'age' => 'required|numeric',
        'email' => 'required|email',
        'name' => 'required',

    );
}
```

The `$labels` property defines user-friendly names for the fields, which will be used in error messages:

``` php
use Rougin\Valla\Check;

class UserCheck extends Check
{
    /**
     * @var array<string, string>
     */
    protected $labels = array(

        'age' => 'Age',
        'email' => 'Email',
        'name' => 'Name',

    );

    // ...
}
```

While the `$rules` property specifies the validation rules for each field:

``` php
use Rougin\Valla\Check;

class UserCheck extends Check
{
    // ...

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'age' => 'required|numeric',
        'email' => 'required|email',
        'name' => 'required',

    );
}
```

> [!NOTE]
> A list of available rules can be found in the [Valitron documentation](https://github.com/vlucas/valitron#validation-rules).

Once the `Check` class is created, it can be used to validate an array of data, such as data from a HTTP request:

``` php
$check = new UserCheck;

$data = /* e.g., data from a request */;

if (! $check->valid($data))
{
    // Get all available errors
    $errors = $check->errors();

    // Or get only the first error
    echo $check->firstError();

    return;
}

// Data has passed validation
```

## Labels, rules

For more complex scenarios, the `labels` and `rules` methods can be overridden to define them dynamically:

``` php
use Rougin\Valla\Check;

class UserCheck extends Check
{
    /**
     * Returns the specified labels.
     *
     * @return array<string, string>
     */
    public function labels()
    {
        $this->labels['is_company'] = 'Is a Company?';

        return $this->labels;
    }

    /**
     * Returns the specified rules based on the data.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules(array $data)
    {
        if (array_key_exists('is_company', $data))
        {
            $this->rules['company_name'] = 'required';
        }

        return $this->rules;
    }
}
```

## Adding custom rules

Custom rules can be added by implementing to `RuleInterface`:

``` php
namespace Rougin\Test\Rules;

use Rougin\Valla\Check;
use Rougin\Valla\RuleInterface;
use Rougin\Valla\Ruleset;

class Uppercase implements RuleInterface
{
    public function getError()
    {
        return 'must be uppercase';
    }

    public function getName()
    {
        return 'uppercase';
    }

    public function passed($value, $data)
    {
        return strtoupper($value) === $value;
    }

    public function setValue(array $values)
    {
        return $this;
    }
}
```

To register the custom rule, add it to a `Ruleset` class then set it to the `Check` class:

``` php
use Rougin\Test\Rules\Uppercase;
use Rougin\Valla\Check;
use Rougin\Valla\Ruleset;

// Register the custom rule ---
$rules = new Ruleset;

$rules->addRule(new Uppercase);
// ----------------------------

// Inject the ruleset to check ---
$check = new Check;

$check->setRuleset($rules);
// -------------------------------

// ...
```

Now the rule `uppercase` can be used as a validation rule:

``` php
protected $rules = array(

    'name' => 'required|uppercase',

);
```

## Built-in rules

Valla ships with 13 built-in rules, each pre-loaded in the default `Ruleset`:

### contains

Checks that the value contains the given substring. Non-string values fail automatically. The error produced is `must contain <needle>`.

``` php
use Rougin\Valla\Ruleset;
use Rougin\Valla\Valid;

$data = array('name' => 'Jane');

$valid = new Valid($data);

$valid->withRule('name', 'contains:Doe');

$valid->passed(); // false, error: "Name must contain Doe"
```

### `creditCard`
Validates a credit card number using the Luhn algorithm. Dashes and spaces are stripped before checking. The error produced is `must be a valid credit card number`.

``` php
$data = array('card' => '123456789');

$rules = (new Ruleset)->resolve('creditCard');
$valid = new Valid($data);
$valid->addRule($rules[0], 'card');

$valid->passed(); // false, error: "Card must be a valid credit card number"
```

### `email`
Validates a properly formatted email address. Non-string values fail automatically. The error produced is `is not a valid email address`.

``` php
$data = array('email' => 'not-an-email');

$rules = (new Ruleset)->resolve('email');
$valid = new Valid($data);
$valid->addRule($rules[0], 'email');

$valid->passed(); // false, error: "Email is not a valid email address"
```

### `in`
Checks that the value matches one of the listed values. The error produced is `contains invalid value`.

``` php
$data = array('role' => 'guest');

$rules = (new Ruleset)->resolve('in:admin,editor');
$valid = new Valid($data);
$valid->addRule($rules[0], 'role');

$valid->passed(); // false, error: "Role contains invalid value"
```

### `instanceOf`
Validates that the value is an instance of the given class. Non-object values fail automatically. The error produced is `must be an instance of '<class>'`.

``` php
$data = array('obj' => new \stdClass);

$rules = (new Ruleset)->resolve('instanceOf:\DateTime');
$valid = new Valid($data);
$valid->addRule($rules[0], 'obj');

$valid->passed(); // false, error: "Obj must be an instance of 'DateTime'"
```

### `lengthMax`
Checks that the value does not exceed the given character length. Non-string values fail automatically. The error produced is `must not exceed <max> characters`.

``` php
$data = array('name' => 'too long');

$rules = (new Ruleset)->resolve('lengthMax:5');
$valid = new Valid($data);
$valid->addRule($rules[0], 'name');

$valid->passed(); // false, error: "Name must not exceed 5 characters"
```

### `lengthMin`
Checks that the value meets the given minimum character length. Non-string values fail automatically. The error produced is `must be at least <min> characters long`.

``` php
$data = array('name' => 'Jo');

$rules = (new Ruleset)->resolve('lengthMin:5');
$valid = new Valid($data);
$valid->addRule($rules[0], 'name');

$valid->passed(); // false, error: "Name must be at least 5 characters long"
```

### `notIn`
Checks that the value does **not** match any of the listed values. The error produced is `contains invalid value`.

``` php
$data = array('role' => 'admin');

$rules = (new Ruleset)->resolve('notIn:admin,editor');
$valid = new Valid($data);
$valid->addRule($rules[0], 'role');

$valid->passed(); // false, error: "Role contains invalid value"
```

### `numeric`
Checks that the value is numeric. The error produced is `must be numeric`.

``` php
$data = array('age' => 'abc');

$rules = (new Ruleset)->resolve('numeric');
$valid = new Valid($data);
$valid->addRule($rules[0], 'age');

$valid->passed(); // false, error: "Age must be numeric"
```

### `required`
Ensures the field is present and not empty. By default, a value is considered empty if it is `null` or a trimmed empty string. Append `:true` for strict mode, which only rejects `null`. The error produced is `is required`.

``` php
$data = array('name' => '');

$rules = (new Ruleset)->resolve('required');
$valid = new Valid($data);
$valid->addRule($rules[0], 'name');

$valid->passed(); // false, error: "Name is required"
```

### `requiredWith`
Makes the field required only when at least one of the listed fields is present and non-empty. For strict mode (null only), append `:true` as the last argument. The error produced is `is required`.

``` php
$data = array('company_name' => '', 'is_company' => 'yes');

$rules = (new Ruleset)->resolve('requiredWith:is_company');
$valid = new Valid($data);
$valid->addRule($rules[0], 'company_name');

$valid->passed(); // false, error: "Company_name is required"
```

### `requiredWithout`
Makes the field required only when at least one of the listed fields is absent or empty. For strict mode (null only), append `:true` as the last argument. The error produced is `is required`.

``` php
$data = array('phone' => '');

$rules = (new Ruleset)->resolve('requiredWithout:email');
$valid = new Valid($data);
$valid->addRule($rules[0], 'phone');

$valid->passed(); // false, error: "Phone is required"
```

### `subset`
Checks that every item in the value (an array) belongs to the listed set. Non-array values fail automatically. The error produced is `contains an item that is not in the list`.

``` php
$data = array('options' => array('a', 'd'));

$rules = (new Ruleset)->resolve('subset:a,b,c');
$valid = new Valid($data);
$valid->addRule($rules[0], 'options');

$valid->passed(); // false, error: "Options contains an item that is not in the list"
```

## Using PSR-7 requests

If using `ServerRequestInterface` from [PSR-7](https://www.php-fig.org/psr/psr-7/), the `Request` class provides a convenient way to validate request data:

``` php
use Rougin\Valla\Request;

class UserCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $aliases = array(

        'username' => 'name',
        'email_add' => 'email',
        'new_age' => 'age',

    );

    // ...
}
```

The `Request` class provides two methods for validation: `isParamsValid` for validating query parameters and `isParsedValid` for validating the parsed body:

``` php
$check = new UserCheck;

// Should return the ServerRequestInterface ---
$request = Http::getServerRequest();
// --------------------------------------------

// Checks against data from "getQueryParams" ---
if ($check->isParamsValid($request))
{
    // Query parameters are valid
}
// ---------------------------------------------

// Checks against data from "getParsedBody" ---
if ($check->isParsedValid($request))
{
    // Parsed body is valid
}
// --------------------------------------------
```

When an alias is specified, it will be used to look for the field in the `ServerRequestInterface` data. For example, if the request data contains a `username` field, it will be validated against the rules defined for the `name` field.

## Overriding the `valid` method

When extending the `Request` class and overriding the `valid` method, the `setAlias` method must be called to apply the defined aliases:

``` php
use Rougin\Valla\Request;

class UserCheck extends Request
{
    // ...

    public function valid($data)
    {
        // Always include this if aliases are defined ---
        $data = $this->setAlias($data);
        // ----------------------------------------------

        if (! parent::valid($data))
        {
            return count($this->errors) === 0;
        }

        // Add extra custom validation conditions here

        return count($this->errors) === 0;
    }
}
```

## Changelog

Please see [CHANGELOG][link-changelog] for more recent changes.

## Contributing

See [CONTRIBUTING][link-contributing] on how to contribute to the project.

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/valla/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/valla?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/valla.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/valla.svg?style=flat-square

[link-build]: https://github.com/rougin/valla/actions
[link-changelog]: https://github.com/rougin/valla/blob/master/CHANGELOG.md
[link-contributing]: https://github.com/rougin/valla/blob/master/CONTRIBUTING.md
[link-coverage]: https://app.codecov.io/gh/rougin/valla
[link-downloads]: https://packagist.org/packages/rougin/valla
[link-license]: https://github.com/rougin/valla/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/valla
