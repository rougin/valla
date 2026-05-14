<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Email implements RuleInterface
{
    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'is not a valid email address';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'email';
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
        if (! is_string($value))
        {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
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
        return $this;
    }
}
