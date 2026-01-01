# Valla

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

A simple validation package based on [Valitron](https://github.com/vlucas/valitron).

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

## Using PSR-7 requests

If using `ServerRequestInterface` from [PSR-7](https://www.php-fig.org/psr/psr-7/), the `Request` class provides a convenient way to validate request data:

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
