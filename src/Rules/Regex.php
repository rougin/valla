<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Regex implements RuleInterface
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'does not match the required pattern';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'regex';
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
        return preg_match($this->pattern, $value) === 1;
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
        $this->pattern = isset($values[0]) ? $values[0] : '';

        return $this;
    }
}
