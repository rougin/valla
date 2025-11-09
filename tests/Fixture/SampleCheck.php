<?php

namespace Rougin\Valla\Fixture;

use Rougin\Valla\Check;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SampleCheck extends Check
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
