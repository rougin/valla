<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Integer implements RuleInterface
{
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
        return 'must be an integer';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'integer';
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
        if ($this->strict)
        {
            return preg_match('/^([0-9]|-[1-9]|-?[1-9][0-9]*)$/i', $value) === 1;
        }

        return filter_var($value, FILTER_VALIDATE_INT) !== false;
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

        return $this;
    }
}
