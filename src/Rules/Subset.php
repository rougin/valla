<?php

namespace Rougin\Valla\Rules;

/**
 * @package Valla
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Subset implements Rule
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
        if (! is_array($value) || ! isset($params[0]) || ! is_array($params[0]))
        {
            return false;
        }

        foreach ($value as $item)
        {
            if (! in_array($item, $params[0]))
            {
                return false;
            }
        }

        return true;
    }
}
