<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Subset implements RuleInterface
{
    /**
     * @var mixed[]
     */
    protected $haystack;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'contains an item that is not in the list';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'subset';
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

        foreach ($value as $item)
        {
            if (! in_array($item, $this->haystack))
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
        $this->haystack = $values;

        return $this;
    }
}
