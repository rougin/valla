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
    protected $labels = array();

    /**
     * @var array<string, string>
     */
    protected $rules = array();

    /**
     * @var \Rougin\Valla\Ruleset|null
     */
    protected $ruleset = null;

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
     * Returns the ruleset instance.
     *
     * @return \Rougin\Valla\Ruleset
     */
    public function getRuleset()
    {
        if ($this->ruleset === null)
        {
            return new Ruleset;
        }

        return $this->ruleset;
    }

    /**
     * Returns the specified rules based on payload.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules(array $data)
    {
        return $this->rules;
    }

    /**
     * Sets the ruleset instance.
     *
     * @param \Rougin\Valla\Ruleset $ruleset
     *
     * @return self
     */
    public function setRuleset(Ruleset $ruleset)
    {
        $this->ruleset = $ruleset;

        return $this;
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
     * Checks if the payload is valid against defined rules.
     *
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function valid(array $data)
    {
        $valid = new Valid($data);

        $labels = $this->labels();

        $valid->setLabels($labels);

        // Resolve the defined rules ----------
        $ruleset = $this->getRuleset();

        $rules = $this->rules($data);

        foreach ($rules as $key => $value)
        {
            $items = $ruleset->resolve($value);

            foreach ($items as $item)
            {
                $valid->addRule($item, $key);
            }
        }
        // ------------------------------------

        if ($valid->passed())
        {
            return count($this->errors) === 0;
        }

        $this->errors = $valid->getErrors();

        return count($this->errors) === 0;
    }
}
