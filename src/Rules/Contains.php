<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Contains implements RuleInterface
{
    /**
     * @var string
     */
    protected $needle;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return sprintf('must contain %s', $this->needle);
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'contains';
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

        return strpos($value, $this->needle) !== false;
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
        $this->needle = isset($values[0]) ? $values[0] : '';

        return $this;
    }
}
