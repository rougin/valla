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
     * @param array<string, mixed> $data
     */
    public function __construct($data = array())
    {
        $this->setData($data);
    }

    /**
     * @param \Rougin\Valla\RuleInterface $rule
     * @param string                      $field
     *
     * @return self
     */
    public function addRule(RuleInterface $rule, $field)
    {
        $this->rules[] = $rule;

        $this->fields[] = $field;

        return $this;
    }

    /**
     * @return array<string, string[]>
     */
    public function getErrors()
    {
        return $this->errors;
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
     * @param array<string, mixed> $data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array<string, string> $labels
     *
     * @return self
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }
}
