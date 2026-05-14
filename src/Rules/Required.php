<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Required implements RuleInterface
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
        return 'is required';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'required';
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
            return ! is_null($value);
        }

        return ! is_null($value) && (is_string($value) ? trim($value) !== '' : true);
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
