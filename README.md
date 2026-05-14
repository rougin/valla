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


## Built-in rules

Valla ships with 13 built-in rules, each pre-loaded in the default `Ruleset`:

### contains

Checks that the value contains the given substring with non-string values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'Jane');

$valid = new Valid($data);

$valid->addRule('name', 'contains:Doe');

// Returns "Name must contain Doe" ---
if (! $valid->passed())
{
    echo $valid->firstError();
}
// -----------------------------------
```

### creditCard

Validates a credit card number using the Luhn algorithm with dashes and spaces stripped before checking:

``` php
use Rougin\Valla\Valid;

$data = array('card' => '123456789');

$valid = new Valid($data);

$valid->addRule('card', 'creditCard');

if (! $valid->passed())
{
    // "Card must be a valid credit card number"
    echo $valid->firstError();
}
```

### email

Validates a properly formatted email address with non-string values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('email' => 'not-an-email');

$valid = new Valid($data);

$valid->addRule('email', 'email');

if (! $valid->passed())
{
    // "Email is not a valid email address"
    echo $valid->firstError();
}
```

### in

Checks that the value matches one of the listed values:

``` php
use Rougin\Valla\Valid;

$data = array('role' => 'guest');

$valid = new Valid($data);

$valid->addRule('role', 'in:admin,editor');

if (! $valid->passed())
{
    // "Role contains invalid value"
    echo $valid->firstError();
}
```

### instanceOf

Validates that the value is an instance of the given class with non-object values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('obj' => new \stdClass);

$valid = new Valid($data);

$valid->addRule('obj', 'instanceOf:\DateTime');

if (! $valid->passed())
{
    // "Obj must be an instance of 'DateTime'"
    echo $valid->firstError();
}
```

### lengthMax

Checks that the value does not exceed the given character length with non-string values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'too long');

$valid = new Valid($data);

$valid->addRule('name', 'lengthMax:5');

if (! $valid->passed())
{
    // "Name must not exceed 5 characters"
    echo $valid->firstError();
}
```

### lengthMin

Checks that the value meets the given minimum character length with non-string values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'Jo');

$valid = new Valid($data);

$valid->addRule('name', 'lengthMin:5');

if (! $valid->passed())
{
    // "Name must be at least 5 characters long"
    echo $valid->firstError();
}
```

### notIn

Checks that the value does not match any of the listed values:

``` php
use Rougin\Valla\Valid;

$data = array('role' => 'admin');

$valid = new Valid($data);

$valid->addRule('role', 'notIn:admin,editor');

if (! $valid->passed())
{
    // "Role contains invalid value"
    echo $valid->firstError();
}
```

### numeric

Checks that the value is numeric:

``` php
use Rougin\Valla\Valid;

$data = array('age' => 'abc');

$valid = new Valid($data);

$valid->addRule('age', 'numeric');

if (! $valid->passed())
{
    // "Age must be numeric"
    echo $valid->firstError();
}
```

### required

Ensures the field is present and not empty with an optional strict mode rejecting only null:

``` php
use Rougin\Valla\Valid;

$data = array('name' => '');

$valid = new Valid($data);

$valid->addRule('name', 'required');

// Returns "Name is required" ---
if (! $valid->passed())
{
    echo $valid->firstError();
}
// --------------------------------
```

### requiredWith

Makes the field required when at least one of the listed fields is present and non-empty:

``` php
use Rougin\Valla\Valid;

$data = array('company_name' => '', 'is_company' => 'yes');

$valid = new Valid($data);

$valid->addRule('company_name', 'requiredWith:is_company');

if (! $valid->passed())
{
    // "Company_name is required"
    echo $valid->firstError();
}
```

### requiredWithout

Makes the field required when at least one of the listed fields is absent or empty:

``` php
use Rougin\Valla\Valid;

$data = array('phone' => '');

$valid = new Valid($data);

$valid->addRule('phone', 'requiredWithout:email');

if (! $valid->passed())
{
    // "Phone is required"
    echo $valid->firstError();
}
```

### subset

Checks that every item in the array belongs to the listed set with non-array values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('options' => array('a', 'd'));

$valid = new Valid($data);

$valid->addRule('options', 'subset:a,b,c');

if (! $valid->passed())
{
    // "Options contains an item that is not in the list"
    echo $valid->firstError();
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

    public function passed($value, array $data)
    {
        return strtoupper($value) === $value;
    }

    public function setValue(array $values)
    {
        return $this;
    }
}
```

To register the custom rule, add it to a `Ruleset` class then set it to the `Valid` class:

``` php
use Rougin\Test\Rules\Uppercase;
use Rougin\Valla\Valid;
use Rougin\Valla\Ruleset;

// Register the custom rule ---
$rules = new Ruleset;

$rules->addRule(new Uppercase);
// ----------------------------

// Inject the ruleset to check ---
$data = array('name' => 'Valla');

$valid = new Valid($data);

$valid->setRuleset($rules);
// -------------------------------

$valid->addRule('name', 'uppercase');

// Returns "Name must contain Doe" ---
if (! $valid->passed())
{
    echo $valid->firstError();
}
// -----------------------------------
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
