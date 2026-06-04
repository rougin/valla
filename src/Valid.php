<?php

namespace Rougin\Valla;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Valid
{
    /**
     * @var array<string, string[]>
     */
    protected $errors = array();

    /**
     * @var array<string, mixed>
     */
    protected $data = array();

    /**
     * @var string[]
     */
    protected $fields = array();

    /**
     * @var array<string, string>
     */
    protected $labels = array();

    /**
     * @var \Rougin\Valla\RuleInterface[]
     */
    protected $rules = array();

    /**
     * @var \Rougin\Valla\Ruleset|null
     */
    protected $ruleset = null;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct($data = array())
    {
        $this->setData($data);
    }

    /**
     * @param string $field
     * @param string $text
     *
     * @return self
     */
    public function addRule($field, $text)
    {
        $ruleset = $this->getRuleset();

        $items = $ruleset->resolve($text);

        foreach ($items as $item)
        {
            $this->rules[] = $item;

            $this->fields[] = $field;
        }

        return $this;
    }

    /**
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
     * @return array<string, string[]>
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
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
     * @return boolean
     */
    public function passed()
    {
        foreach ($this->rules as $index => $rule)
        {
            // Check the field against its rule ------
            $field = $this->fields[$index];

            $value = null;

            if (array_key_exists($field, $this->data))
            {
                $value = $this->data[$field];
            }

            if ($rule->passed($value, $this->data))
            {
                continue;
            }
            // ---------------------------------------

            // Add the error if the rule failed --------
            $label = ucfirst($field);

            if (array_key_exists($field, $this->labels))
            {
                $label = $this->labels[$field];
            }

            $error = $label . ' ' . $rule->getError();

            $this->errors[$field][] = $error;
            // -----------------------------------------
        }

        return count($this->errors) === 0;
    }

    /**
     * @deprecated since ~0.1, use "addRule" instead.
     *
     * Convenience method to add a single validation rule.
     *
     * @param callable|string $rule
     * @param string|string[] $fields
     *
     * @return self
     */
    public function rule($rule, $fields)
    {
        if (! is_string($rule))
        {
            $text = 'Valla does not support callable rules. ';

            $text .= 'Implement Rougin\Valla\RuleInterface instead.';

            throw new \InvalidArgumentException($text);
        }

        $params = array_slice(func_get_args(), 2);

        $text = $rule;

        if (count($params) > 0)
        {
            /** @phpstan-ignore-next-line */
            $text .= ':' . implode(',', $params);
        }

        if (! is_array($fields))
        {
            $fields = array($fields);
        }

        foreach ($fields as $field)
        {
            $this->addRule($field, $text);
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array<string, string> $labels
     *
     * @return self
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @param \Rougin\Valla\Ruleset $ruleset
     *
     * @return self
     */
    public function setRuleset(Ruleset $ruleset)
    {
        $this->ruleset = $ruleset;

        return $this;
    }
}
