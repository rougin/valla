<?php

namespace Rougin\Validia;

use Valitron\Validator;

/**
 * @package Validia
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Check
{
    /**
     * @var array<string, string[]>
     */
    protected $errors = array();

    /**
     * @var array<string, string>
     */
    protected $labels = array();

    /**
     * @var array<string, string>
     */
    protected $rules = array();

    /**
     * Returns all errors after validation.
     *
     * @return array<string, string[]>
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Returns the first error after validation.
     *
     * @return string|null
     */
    public function firstError()
    {
        if (! $this->errors)
        {
            return null;
        }

        $values = array_values($this->errors);

        return $values[0][0];
    }

    /**
     * Returns the specified labels.
     *
     * @return array<string, string>
     */
    public function labels()
    {
        return $this->labels;
    }

    /**
     * Returns the specified rules based from the payload.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules($data)
    {
        return $this->rules;
    }

    /**
     * Adds a new error message to the specified key.
     *
     * @param string $key
     * @param string $text
     *
     * @return self
     */
    public function setError($key, $text)
    {
        $exists = array_key_exists($key, $this->errors);

        if (! $exists)
        {
            $this->errors[$key] = array();
        }

        $items = $this->errors[$key];

        $items[] = $text;

        $this->errors[$key] = $items;

        return $this;
    }

    /**
     * Checks if the payload is valid againsts the specified rules.
     *
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function valid($data)
    {
        $valid = new Validator;

        $valid->labels($this->labels());

        $rules = $this->rules($data);

        foreach ($rules as $key => $value)
        {
            $rule = new Rule($valid);

            $valid = $rule->parse($key, $value);
        }

        $valid = $valid->withData($data);

        if ($valid->validate())
        {
            return count($this->errors) === 0;
        }

        /** @var array<string, string[]> */
        $errors = $valid->errors();

        foreach ($errors as $name => $items)
        {
            foreach ($items as $item)
            {
                $this->setError($name, $item);
            }
        }

        return count($this->errors) === 0;
    }
}
