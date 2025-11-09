<?php

namespace Rougin\Valla\Fixture;

use Rougin\Valla\Request;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequestCheck extends Request
{
    /**
     * @var array<string, string>
     */
    protected $aliases = array(

        'username' => 'name',
        'email_add' => 'email',

    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'name' => 'required',
        'email' => 'required|email',

    );
}
