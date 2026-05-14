<?php

namespace Rougin\Valla\Rules;

use Rougin\Valla\RuleInterface;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DateFormat implements RuleInterface
{
    /**
     * @var string
     */
    protected $format;

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError()
    {
        return 'must be a valid date format';
    }

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName()
    {
        return 'dateFormat';
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
        $parsed = date_parse_from_format($this->format, $value);

        return $parsed['error_count'] === 0 && $parsed['warning_count'] === 0;
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
        $this->format = isset($values[0]) ? $values[0] : '';

        return $this;
    }
}
