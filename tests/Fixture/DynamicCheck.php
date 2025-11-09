<?php

namespace Rougin\Valla\Fixture;

use Rougin\Valla\Check;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DynamicCheck extends Check
{
    /**
     * @var array<string, string>
     */
    protected $labels = array(

        'company_name' => 'Company Name',

    );

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules($data)
    {
        if (isset($data['is_company']) && $data['is_company'])
        {
            $this->rules['company_name'] = 'required';
        }

        return $this->rules;
    }
}
