<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthBetween implements RuleInterface
{
    /**
     * @var integer
     */
    protected $min;

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
        return sprintf('must be between %d and %d characters', $this->min, $this->max);
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'lengthBetween';
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

        $length = strlen($value);

        return $length >= $this->min && $length <= $this->max;
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
        $this->min = isset($values[0]) ? (int) $values[0] : 0;

        $this->max = isset($values[1]) ? (int) $values[1] : 0;

        return $this;
    }
}
