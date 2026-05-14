<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequiredWithout implements RuleInterface
{
    /**
     * @var string[]
     */
    protected $fields;

    /**
     * @var boolean
     */
    protected $strict;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'is required';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'requiredWithout';
    }

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function passed($value, $data)
    {
        $required = false;

        foreach ($this->fields as $item)
        {
            if (! isset($data[$item]) || empty($data[$item]))
            {
                $required = true;

                break;
            }
        }

        if ($required)
        {
            $rule = new Required;

            $rule->setValue($this->strict ? array('true') : array());

            return $rule->passed($value, $data);
        }

        return true;
    }

    /**
     * Sets the parameter values for the rule.
     *
     * @param string[] $values
     *
     * @return self
     */
    public function setValue(array $values)
    {
        $last = end($values);

        $this->strict = is_string($last) && trim($last) === 'true';

        $this->fields = $values;

        return $this;
    }
}
