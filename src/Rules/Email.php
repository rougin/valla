<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Email implements Rule
{
    /**
     * Checks if the specified value passes the rule.
     *
     * @param mixed                $value
     * @param mixed[]              $params
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function pass($value, $params = array(), $data = array())
    {
        if (! is_string($value))
        {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
