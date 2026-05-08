<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class LengthMin implements Rule
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
        if (! is_string($value) || ! isset($params[0]) || ! is_scalar($params[0]))
        {
            return false;
        }

        /** @var int */
        $p = (int) $params[0];

        return strlen($value) >= $p;
    }
}
