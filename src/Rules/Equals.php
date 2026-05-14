<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Equals implements RuleInterface
{
    /**
     * @var string
     */
    protected $field;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return sprintf('must be equal to %s', $this->field);
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'equals';
    }

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function passed($value, array $data)
    {
        if (! isset($data[$this->field]))
        {
            return false;
        }

        return $value == $data[$this->field];
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
        $this->field = isset($values[0]) ? $values[0] : '';

        return $this;
    }
}
