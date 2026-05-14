<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ArrayHasKeys implements RuleInterface
{
    /**
     * @var string[]
     */
    protected $keys;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'must contain the required keys';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'arrayHasKeys';
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
        if (! is_array($value))
        {
            return false;
        }

        foreach ($this->keys as $key)
        {
            if (! array_key_exists($key, $value))
            {
                return false;
            }
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
        $this->keys = $values;

        return $this;
    }
}
