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
     * Returns the name of the rule.
     *
     * @return string
     */
    public static function getName();

    /**
     * Returns the error message template.
     *
     * @return string
     */
    public function getError();

    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function pass($value, $data = array());
}
