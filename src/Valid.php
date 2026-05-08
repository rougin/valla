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
     * @var array<string, string>
     */
    protected $labels = array();

    /**
     * @var array<int, array<string, mixed>>
     */
    protected $rules = array();

    /**
     * @param array<string, mixed> $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @param RuleInterface $rule
     * @param mixed         $fields
     *
     * @return self
     */
    public function add(RuleInterface $rule, $fields)
    {
        foreach ((array) $fields as $field)
        {
            if (is_scalar($field) || (is_object($field) && method_exists($field, '__toString')))
            {
                $this->rules[] = array(
                    'rule' => $rule,
                    'field' => (string) $field,
                );
            }
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function check()
    {
        foreach ($this->rules as $item)
        {
            /** @var RuleInterface */
            $rule = $item['rule'];

            /** @var string */
            $field = $item['field'];

            $value = isset($this->data[$field]) ? $this->data[$field] : null;

            if (! $rule->pass($value, $this->data))
            {
                $this->setError($field, $rule);
            }
        }

        return count($this->errors) === 0;
    }

    /**
     * @return array<string, string[]>
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return self
     */
    public function withData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array<string, string> $labels
     *
     * @return self
     */
    public function withLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @param string        $field
     * @param RuleInterface $rule
     *
     * @return void
     */
    protected function setError($field, RuleInterface $rule)
    {
        $label = isset($this->labels[$field]) ? $this->labels[$field] : ucfirst($field);

        $message = $rule->getError();

        $this->errors[$field][] = $label . ' ' . $message;
    }
}
