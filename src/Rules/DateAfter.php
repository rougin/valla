<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DateAfter implements RuleInterface
{
    /**
     * @var string
     */
    protected $date;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return sprintf('must be a date after %s', $this->date);
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'dateAfter';
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
        $vtime = $value instanceof \DateTime ? $value->getTimestamp() : strtotime($value);

        $ptime = strtotime($this->date);

        return $vtime !== false && $ptime !== false && $vtime > $ptime;
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
        $this->date = isset($values[0]) ? $values[0] : '';

        return $this;
    }
}
