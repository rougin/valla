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
     * @var array<string, mixed>
     */
    protected $_data = array();

    /**
     * @var array<string, string[]>
     */
    protected $_errors = array();

    /**
     * @var array<string, string>
     */
    protected $_labels = array();

    /**
     * @var array<int, array<string, mixed>>
     */
    protected $_rules = array();

    /**
     * @var array<string, string>
     */
    protected $_messages = array(
        'required' => 'is required',
        'email' => 'is not a valid email address',
        'numeric' => 'must be numeric',
        'in' => 'contains invalid value',
        'notIn' => 'contains invalid value',
        'contains' => 'must contain %s',
        'subset' => 'contains an item that is not in the list',
        'lengthMin' => 'must be at least %d characters long',
        'lengthMax' => 'must not exceed %d characters',
        'instanceOf' => 'must be an instance of \'%s\'',
        'creditCard' => 'must be a valid credit card number',
        'requiredWith' => 'is required',
        'requiredWithout' => 'is required',
    );

    /**
     * @param array<string, mixed> $data
     */
    public function __construct($data = array())
    {
        $this->_data = $data;
    }

    /**
     * @return array<string, string[]>
     */
    public function errors()
    {
        return $this->_errors;
    }

    /**
     * @param array<string, string> $labels
     *
     * @return self
     */
    public function labels($labels)
    {
        $this->_labels = $labels;

        return $this;
    }

    /**
     * @param string $rule
     * @param mixed  $fields
     *
     * @return self
     */
    public function add($rule, $fields)
    {
        $params = array_slice(func_get_args(), 2);

        foreach ((array) $fields as $field)
        {
            if (is_scalar($field) || (is_object($field) && method_exists($field, '__toString')))
            {
                $this->_rules[] = array(
                    'rule' => $rule,
                    'field' => (string) $field,
                    'params' => $params,
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
        foreach ($this->_rules as $item)
        {
            /** @var string */
            $rule = $item['rule'];

            /** @var string */
            $field = $item['field'];

            /** @var mixed[] */
            $params = $item['params'];

            $value = isset($this->_data[$field]) ? $this->_data[$field] : null;

            if (! $this->pass($rule, $value, $params))
            {
                $this->error($field, $rule, $params);
            }
        }

        return count($this->_errors) === 0;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return self
     */
    public function withData($data)
    {
        $instance = clone $this;

        $instance->_data = $data;

        return $instance;
    }

    /**
     * @param string  $field
     * @param string  $rule
     * @param mixed[] $params
     *
     * @return void
     */
    protected function error($field, $rule, $params)
    {
        $label = isset($this->_labels[$field]) ? $this->_labels[$field] : ucfirst($field);

        $message = $this->_messages[$rule];

        if ($rule === 'contains' && isset($params[0]) && is_array($params[0]))
        {
            /** @var string[] */
            $p = $params[0];

            $message = sprintf($message, $p[0]);
        }

        if ($rule === 'instanceOf' && isset($params[0]) && is_object($params[0]))
        {
            $message = sprintf($message, get_class($params[0]));
        }

        if (($rule === 'lengthMin' || $rule === 'lengthMax') && isset($params[0]))
        {
            /** @var int|string */
            $p = $params[0];

            $message = sprintf($message, $p);
        }

        $this->_errors[$field][] = $label . ' ' . $message;
    }

    /**
     * @param string  $rule
     * @param mixed   $value
     * @param mixed[] $params
     *
     * @return boolean
     */
    protected function pass($rule, $value, $params)
    {
        $class = 'Rougin\Valla\Rules\\' . ucfirst($rule);

        if ($rule === 'instanceOf')
        {
            $class = 'Rougin\Valla\Rules\IsInstance';
        }

        if (! class_exists($class))
        {
            return true;
        }

        /** @var \Rougin\Valla\Rules\Rule */
        $instance = new $class;

        return $instance->pass($value, $params, $this->_data);
    }
}
