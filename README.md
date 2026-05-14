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

## Overriding `valid` method

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

## Built-in rules

Valla ships with 43 built-in rules, each pre-loaded in the default `Ruleset`:

### contains

Checks that the value contains the given substring with non-string values fail automatically:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'Jane');

$valid = new Valid($data);

$valid->addRule('name', 'contains:Doe');

if (! $valid->passed())
{
    // "Name must contain Doe"
    echo $valid->firstError();
}
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

if (! $valid->passed())
{
    // "Name is required"
    echo $valid->firstError();
}
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

### accepted

Checks that the value is one of yes, on, 1, or true:

``` php
use Rougin\Valla\Valid;

$data = array('terms' => 'no');

$valid = new Valid($data);

$valid->addRule('terms', 'accepted');

if (! $valid->passed())
{
    // "Terms is not accepted"
    echo $valid->firstError();
}
```

### alpha

Checks that the value contains only alphabetic characters:

``` php
use Rougin\Valla\Valid;

$data = array('name' => '123');

$valid = new Valid($data);

$valid->addRule('name', 'alpha');

if (! $valid->passed())
{
    // "Name must contain only alphabetic characters"
    echo $valid->firstError();
}
```

### alphaNum

Checks that the value contains only alpha-numeric characters:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'test!@#');

$valid = new Valid($data);

$valid->addRule('name', 'alphaNum');

if (! $valid->passed())
{
    // "Name must contain only alpha-numeric characters"
    echo $valid->firstError();
}
```

### array

Checks that the value is an array:

``` php
use Rougin\Valla\Valid;

$data = array('items' => 'string');

$valid = new Valid($data);

$valid->addRule('items', 'array');

if (! $valid->passed())
{
    // "Items must be an array"
    echo $valid->firstError();
}
```

### arrayHasKeys

Checks that the array value contains all of the specified keys:

``` php
use Rougin\Valla\Valid;

$data = array('data' => array('a' => 1));

$valid = new Valid($data);

$valid->addRule('data', 'arrayHasKeys:a,b');

if (! $valid->passed())
{
    // "Data must contain the required keys"
    echo $valid->firstError();
}
```

### ascii

Checks that the value contains only ASCII characters:

``` php
use Rougin\Valla\Valid;

$data = array('name' => "J\xC3\xA1ne");

$valid = new Valid($data);

$valid->addRule('name', 'ascii');

if (! $valid->passed())
{
    // "Name must contain only ASCII characters"
    echo $valid->firstError();
}
```

### between

Checks that the numeric value falls between the given minimum and maximum:

``` php
use Rougin\Valla\Valid;

$data = array('age' => 25);

$valid = new Valid($data);

$valid->addRule('age', 'between:1,20');

if (! $valid->passed())
{
    // "Age must be between 1 and 20"
    echo $valid->firstError();
}
```

### boolean

Checks that the value is a boolean:

``` php
use Rougin\Valla\Valid;

$data = array('flag' => 'yes');

$valid = new Valid($data);

$valid->addRule('flag', 'boolean');

if (! $valid->passed())
{
    // "Flag must be a boolean"
    echo $valid->firstError();
}
```

### containsUnique

Checks that the array value contains only unique values:

``` php
use Rougin\Valla\Valid;

$data = array('items' => array('a', 'b', 'a'));

$valid = new Valid($data);

$valid->addRule('items', 'containsUnique');

if (! $valid->passed())
{
    // "Items must contain unique values only"
    echo $valid->firstError();
}
```

### date

Checks that the value is a valid date string:

``` php
use Rougin\Valla\Valid;

$data = array('birthday' => 'not-a-date');

$valid = new Valid($data);

$valid->addRule('birthday', 'date');

if (! $valid->passed())
{
    // "Birthday must be a valid date"
    echo $valid->firstError();
}
```

### dateAfter

Checks that the value is a date after the specified date:

``` php
use Rougin\Valla\Valid;

$data = array('date' => '2020-01-01');

$valid = new Valid($data);

$valid->addRule('date', 'dateAfter:2023-01-01');

if (! $valid->passed())
{
    // "Date must be a date after 2023-01-01"
    echo $valid->firstError();
}
```

### dateBefore

Checks that the value is a date before the specified date:

``` php
use Rougin\Valla\Valid;

$data = array('date' => '2024-01-01');

$valid = new Valid($data);

$valid->addRule('date', 'dateBefore:2023-01-01');

if (! $valid->passed())
{
    // "Date must be a date before 2023-01-01"
    echo $valid->firstError();
}
```

### dateFormat

Checks that the value matches the specified date format (e.g., `Y-m-d`):

``` php
use Rougin\Valla\Valid;

$data = array('date' => '01-01-2023');

$valid = new Valid($data);

$valid->addRule('date', 'dateFormat:Y-m-d');

if (! $valid->passed())
{
    // "Date must be a valid date format"
    echo $valid->firstError();
}
```

### different

Checks that the value is different from the value of another field:

``` php
use Rougin\Valla\Valid;

$data = array('a' => 'hello', 'b' => 'hello');

$valid = new Valid($data);

$valid->addRule('a', 'different:b');

if (! $valid->passed())
{
    // "A must be different from b"
    echo $valid->firstError();
}
```

### emailDNS

Checks that the value is an email address with an active domain (MX record):

``` php
use Rougin\Valla\Valid;

$data = array('email' => 'test@nonexistent-domain.invalid');

$valid = new Valid($data);

$valid->addRule('email', 'emailDNS');

if (! $valid->passed())
{
    // "Email must be a valid email address with active domain"
    echo $valid->firstError();
}
```

### equals

Checks that the value equals the value of another field:

``` php
use Rougin\Valla\Valid;

$data = array('a' => 'hello', 'b' => 'world');

$valid = new Valid($data);

$valid->addRule('a', 'equals:b');

if (! $valid->passed())
{
    // "A must be equal to b"
    echo $valid->firstError();
}
```

### integer

Checks that the value is an integer with an optional strict mode:

``` php
use Rougin\Valla\Valid;

$data = array('age' => 'abc');

$valid = new Valid($data);

$valid->addRule('age', 'integer');

if (! $valid->passed())
{
    // "Age must be an integer"
    echo $valid->firstError();
}
```

### ip

Checks that the value is a valid IP address:

``` php
use Rougin\Valla\Valid;

$data = array('ip' => 'not-an-ip');

$valid = new Valid($data);

$valid->addRule('ip', 'ip');

if (! $valid->passed())
{
    // "Ip must be a valid IP address"
    echo $valid->firstError();
}
```

### ipv4

Checks that the value is a valid IPv4 address:

``` php
use Rougin\Valla\Valid;

$data = array('ip' => '::1');

$valid = new Valid($data);

$valid->addRule('ip', 'ipv4');

if (! $valid->passed())
{
    // "Ip must be a valid IPv4 address"
    echo $valid->firstError();
}
```

### ipv6

Checks that the value is a valid IPv6 address:

``` php
use Rougin\Valla\Valid;

$data = array('ip' => '192.168.1.1');

$valid = new Valid($data);

$valid->addRule('ip', 'ipv6');

if (! $valid->passed())
{
    // "Ip must be a valid IPv6 address"
    echo $valid->firstError();
}
```

### length

Checks that the string length matches an exact value or falls between min and max:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'Jo');

$valid = new Valid($data);

$valid->addRule('name', 'length:5');

if (! $valid->passed())
{
    // "Name must be exactly 5 characters"
    echo $valid->firstError();
}
```

### lengthBetween

Checks that the string length falls between the given min and max:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'too long');

$valid = new Valid($data);

$valid->addRule('name', 'lengthBetween:1,5');

if (! $valid->passed())
{
    // "Name must be between 1 and 5 characters"
    echo $valid->firstError();
}
```

### listContains

Checks that the array value contains the specified item:

``` php
use Rougin\Valla\Valid;

$data = array('items' => array('a', 'b'));

$valid = new Valid($data);

$valid->addRule('items', 'listContains:c');

if (! $valid->passed())
{
    // "Items must contain the specified value"
    echo $valid->firstError();
}
```

### max

Checks that the numeric value does not exceed the given maximum:

``` php
use Rougin\Valla\Valid;

$data = array('age' => 25);

$valid = new Valid($data);

$valid->addRule('age', 'max:20');

if (! $valid->passed())
{
    // "Age must not exceed 20"
    echo $valid->firstError();
}
```

### min

Checks that the numeric value is at least the given minimum:

``` php
use Rougin\Valla\Valid;

$data = array('age' => 5);

$valid = new Valid($data);

$valid->addRule('age', 'min:10');

if (! $valid->passed())
{
    // "Age must be at least 10"
    echo $valid->firstError();
}
```

### optional

Always passes regardless of the value, allowing a field to be optional:

``` php
use Rougin\Valla\Valid;

$data = array('field' => '');

$valid = new Valid($data);

$valid->addRule('field', 'optional');

// [NOTE] Optional rules always pass
$valid->passed();
```

### regex

Checks that the value matches the given regular expression:

``` php
use Rougin\Valla\Valid;

$data = array('name' => 'hello');

$valid = new Valid($data);

$valid->addRule('name', 'regex:/^[0-9]+$/');

if (! $valid->passed())
{
    // "Name does not match the required pattern"
    echo $valid->firstError();
}
```

### slug

Checks that the value is a valid slug (alpha-numeric, dashes, underscores):

``` php
use Rougin\Valla\Valid;

$data = array('slug' => 'not a slug!');

$valid = new Valid($data);

$valid->addRule('slug', 'slug');

if (! $valid->passed())
{
    // "Slug must be a valid slug"
    echo $valid->firstError();
}
```

### url

Checks that the value is a valid URL starting with http, https, or ftp:

``` php
use Rougin\Valla\Valid;

$data = array('link' => 'not-a-url');

$valid = new Valid($data);

$valid->addRule('link', 'url');

if (! $valid->passed())
{
    // "Link must be a valid URL"
    echo $valid->firstError();
}
```

### urlActive

Checks that the value is a valid URL with an active domain (DNS record):

``` php
use Rougin\Valla\Valid;

$data = array('link' => 'http://nonexistent-domain.invalid');

$valid = new Valid($data);

$valid->addRule('link', 'urlActive');

if (! $valid->passed())
{
    // "Link must be a valid URL with active domain"
    echo $valid->firstError();
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
