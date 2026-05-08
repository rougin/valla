<?php

namespace Rougin\Valla;

/**
 * @package Valla
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
    protected $rules = array();

    /**
     * @var array<string, string>
     */
    protected $labels = array();

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
     * Returns the specified rules based on payload.
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
        if (! isset($this->errors[$key]))
        {
            $this->errors[$key] = array();
        }

        $this->errors[$key][] = $text;

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
        $valid = new Valid;

        $valid->setLabels($this->labels());

        // Initialize the defined rules --------
        $rules = $this->rules($data);

        foreach ($rules as $key => $value)
        {
            $rule = new Rule($valid);

            $valid = $rule->match($key, $value);
        }
        // -------------------------------------

        $valid = $valid->setData($data);

        if ($valid->isOkay())
        {
            return count($this->errors) === 0;
        }

        $this->errors = $valid->getErrors();

        return count($this->errors) === 0;
    }
}
