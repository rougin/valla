<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMax implements RuleInterface
{
    /**
     * @var integer
     */
    protected $max;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return sprintf('must not exceed %d characters', $this->max);
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'lengthMax';
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

        return strlen($value) <= $this->max;
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
        $this->max = isset($values[0]) ? (int) $values[0] : 0;

        return $this;
    }
}
