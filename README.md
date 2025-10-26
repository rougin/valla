# Valla

A simple validation package based on [Valitron](https://github.com/vlucas/valitron).

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
    protected $labels =
    [
        'age' => 'Age',
        'email' => 'Email',
        'name' => 'Name',
    ];

    /**
     * @var array<string, string>
     */
    protected $rules =
    [
        'age' => 'required|numeric',
        'email' => 'required|email',
        'name' => 'required',
    ];
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
    protected $labels =
    [
        'age' => 'Age',
        'email' => 'Email',
        'name' => 'Name',
    ];

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
    protected $rules =
    [
        'age' => 'required|numeric',
        'email' => 'required|email',
        'name' => 'required',
    ];
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

## Dynamic labels, rules

For more complex scenarios, the `labels` and `rules` methods can be overridden to define labels and rules dynamically:

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
    public function rules($data)
    {
        if (array_key_exists('is_company', $data))
        {
            $this->rules['company_name'] = 'required';
        }

        return $this->rules;
    }
}
```

## Working with PSR-7 requests

If using `ServerRequestInterface` of [PSR-7](https://www.php-fig.org/psr/psr-7/), the `Request` class provides a convenient way to validate request data:

``` php
use Rougin\Valla\Request;

class UserCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $aliases =
    [
        'username' => 'name',
        'email_add' => 'email',
        'new_age' => 'age',
    ];

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

When extending the `Request` class and overriding the `valid` method, the `setAlias` method must be called to apply the defined aliases.

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

        $valid = parent::valid($data);

        if (! $valid)
        {
            return count($this->errors) === 0;
        }

        // Add extra custom validation conditions here

        return count($this->errors) === 0;
    }
}
```

## Change log

See [CHANGELOG](CHANGELOG.md) for more recent changes.

## Development

Includes tools for code quality, coding style, and unit tests.

### Code quality

Analyze code quality using [phpstan](https://phpstan.org/):

``` bash
$ phpstan
```

### Coding style

Enforce coding style using [php-cs-fixer](https://cs.symfony.com/):

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

### Unit tests

Execute unit tests using [phpunit](https://phpunit.de/index.html):

``` bash
$ composer test
```
