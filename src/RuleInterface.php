<?php

namespace Rougin\Valla;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface RuleInterface
{
    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError();

    /**
     * Returns the name of the rule.
     *
     * @return string
     */
    public function getName();

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function passed($value, array $data);

    /**
     * Sets the parameter values for the rule.
     *
     * @param string[] $values
     *
     * @return self
     */
    public function setValue(array $values);
}
