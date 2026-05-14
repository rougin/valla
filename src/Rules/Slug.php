<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Slug implements RuleInterface
{
    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'must be a valid slug';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'slug';
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
        if (is_array($value))
        {
            return false;
        }

        return preg_match('/^([-a-z0-9_-])+$/i', $value) === 1;
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
